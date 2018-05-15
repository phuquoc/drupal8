<?php

/**
 * @file
 * API documentation for Freelinking.
 */

/**
 * Used to alter the plugin definition of freelinking plugins.
 *
 * @param array $plugins
 *   An array of all existing plugin definitions, passed by reference.
 *
 * @see \Drupal\freelinking\Annotation\Freelinking
 */
function hook_freelinking_plugin_info_alter(array &$plugins) {
  $plugins['someplugin']['title'] = t('Better title');
}

/**
 * Used to alter a freelinking link before passed to the theming system.
 *
 * @param array &$link
 *   A render array generated by a freelinking plugin. This may be a render
 *   array that describes a link or plain markup depending on the plugin.
 * @param array $data
 *   An associative array containing information about the content:
 *   - target: the target string
 *   - plugin_name: the plugin ID.
 *   - plugin: The freelinking plugin instance.
 *
 * @see \Drupal\freelinking\Plugin\FreelinkingPluginInterface::buildLink()
 */
function hook_freelinking_freelink_alter(array &$link, array $data) {
  $link['#attributes']['class'][] = 'active';
}

/**
 * @} End of "addtogroup hooks".
 */