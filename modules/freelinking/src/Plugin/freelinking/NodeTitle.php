<?php

namespace Drupal\freelinking\Plugin\freelinking;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Url;
use Drupal\freelinking\Plugin\FreelinkingPluginBase;
use Drupal\freelinking\Plugin\FreelinkingPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Node Title freelinking plugin.
 *
 * @Freelinking(
 *   id = "nodetitle",
 *   title = @Translation("Node title"),
 *   weight = -10,
 *   hidden = false,
 *   settings = {
 *     "nodetypes" = {},
 *     "failover" = "",
 *   }
 * )
 */
class NodeTitle extends FreelinkingPluginBase implements FreelinkingPluginInterface, ContainerFactoryPluginInterface {

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Entity query.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entityQuery;

  /**
   * Module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Initialize method.
   *
   * @param array $configuration
   *   Plugin configugration.
   * @param string $plugin_id
   *   Plugin Id.
   * @param mixed $plugin_definition
   *   Plugin definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager for getting entity type.
   * @param \Drupal\Core\Entity\Query\QueryFactory $entityQuery
   *   Entity query for getting content types and node.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entityTypeManager, QueryFactory $entityQuery, ModuleHandlerInterface $moduleHandler) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityQuery = $entityQuery;
    $this->entityTypeManager = $entityTypeManager;
    $this->moduleHandler = $moduleHandler;
  }

  /**
   * {@inheritdoc}
   */
  public function getIndicator() {
    return '/nt$|nodetitle|title/A';
  }

  /**
   * {@inheritdoc}
   */
  public function getTip() {
    return $this->t('Click to view a local node.');
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
      'settings' => [
        'nodetypes' => [],
        'failover' => '',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = [];
    $node_type_options = [];

    // Get the node type entities from storage from Entity Type Manager.
    // \Drupal\Core\Entity\EntityTypeBundleInfo::getAllBundleInfo() offers an
    // alter, but increased load times when not cached. It is debatable which
    // should be used in the long term.
    $node_types = $this->entityTypeManager->getStorage('node_type')->loadMultiple();
    foreach ($node_types as $entity) {
      $node_type_options[$entity->id()] = $entity->label();
    }

    $element['nodetypes'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Only link to nodes belonging to the following content types:'),
      '#description' => $this->t('Lookup by title to will be restricted to this content type or these content types.'),
      '#options' => $node_type_options,
      '#default_value' => isset($this->configuration['settings']['nodetypes']) ? $this->configuration['settings']['nodetypes'] : [],
    ];

    $failover_options = [
      '_none' => $this->t('Do Nothing'),
      'showtext' => $this->t('Show text (remove markup)'),
    ];

    // @todo prepopulate option.

    if ($this->moduleHandler->moduleExists('search')) {
      $failover_options['search'] = $this->t('Add link to search content');
    }

    $failover_options['error'] = $this->t('Insert an error message');

    $element['failover'] = [
      '#type' => 'select',
      '#title' => $this->t('If suitable content is not found'),
      '#description' => $this->t('What should freelinking do when the page is not found?'),
      '#options' => $failover_options,
      '#default_value' => isset($this->configuration['settings']['failover']) ? $this->configuration['settings']['failover'] : '',
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function buildLink(array $target) {
    $link = '';

    // @todo failover.
    $failover_option = $this->getConfiguration()['settings']['failover'];

    /** @var \Drupal\Core\Entity\Query\QueryInterface $query */
    $query = $this->entityQuery->get('node', 'AND');
    $node_types = $this->getAllowedNodeTypes();
    if (!empty($node_types)) {
      $query->condition('type', $node_types, 'IN');
    }
    $result = $query
      ->condition('title', $target['dest'])
      ->condition('status', 1)
      ->condition('langcode', $target['language']->getId())
      ->accessCheck()
      ->execute();

    if (!empty($result)) {
      $nid = array_shift($result);
      $link = [
        '#type' => 'link',
        '#title' => $target['dest'],
        '#url' => Url::fromRoute('entity.node.canonical', ['node' => $nid], ['language' => $target['language']]),
        '#attributes' => [
          'title' => $this->getTip(),
        ],
      ];
    }
    elseif ($failover_option === 'showtext') {
      $link = [
        '#markup' => $target['dest'],
      ];
    }
    elseif ($failover_option === 'search' && $this->moduleHandler->moduleExists('search')) {
      $link = [
        '#type' => 'link',
        '#title' => $target['dest'],
        '#url' => Url::fromUserInput(
          '/search/node',
          [
            'language' => $target['language'],
            'query' => ['keys' => $target['dest']],
          ]
        ),
      ];
    }
    elseif ($failover_option === 'error') {
      $link = [
        '#theme' => 'freelink_error',
        '#plugin' => 'nodetitle',
        '#message' => $this->t('Node title %target does not exist', ['%target' => $target['dest']]),
      ];
    }
    else {
      $link = [
        '#markup' => '[[nodetitle:' . $target['target'] . ']]',
      ];
    }

    return $link;
  }

  /**
   * {@inheritdoc}
   */
  static public function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('entity.query'),
      $container->get('module_handler')
    );
  }

  /**
   * Get the allowed node types from configuration.
   *
   * @return array
   *   An indexed array of node types.
   */
  protected function getAllowedNodeTypes() {
    $node_types = $this->configuration['settings']['nodetypes'];
    return array_reduce($node_types, function (&$result, $item) {
      if ($item) {
        $result[] = $item;
      }
      return $result;
    }, []);
  }

}
