<?php

/* modules/tmgmt/modules/demo/templates/tmgmt-demo-text.html.twig */
class __TwigTemplate_b75b516d1629555dfa37dd0b695ea49a87fc37b4cab761ce1bdde6c643dbc6d7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array();
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array(),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 17
        echo "<p>Welcome to the Translation Management Tool Demo module!</p>

<p>The Translation Management Tool (TMGMT) demo module provides the configuration needed for translating predefined content types - <a href=\"";
        // line 19
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["content_language"] ?? null), "html", null, true));
        echo "\">translatable nodes</a>.</p>

<p>It enables three <a href=\"";
        // line 21
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["languages_url"] ?? null), "html", null, true));
        echo "\">languages</a>. Besides English, it supports German and French.</p>

<p>Content translation is enabled by default. This allows users to translate the content on their own. Also, Export / Import File translator enables exporting source data into a file and import the translated in return.</p>

<ul>
  <li><span>To get started with the translation, two <a href=\"";
        // line 26
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["translatable_nodes"] ?? null), "html", null, true));
        echo "\">translatable nodes</a> are created. The steps for translation are the following:</span>

  <ul>
    <li>On the node detail view use the <a href=\"";
        // line 29
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["translate_url"] ?? null), "html", null, true));
        echo "\">\"translate\" Tab</a>, choose a language and click \"Request Translation\" to get started.</li>
    <li>After submitting the job, the status is changed to \"In progress\". In case of a machine translator, the translation is immediately returned. The status is then \"Needs review\".</li>
    <li>\"In progress\" is the state where we are awaiting the translations from the translator.</li>
    <li>Once the translations are provided by the translator, we can review the job items (and correct) the translated content. Some translators support feedback cycles. We can send an item that needs a better translation back to the translator with some comments. If the translation is fine, we can accept the job items (or the job). This is when the source items are updated/the translation is created.</li>
    <li>The job is finally in the state of being published</li>
  </ul>
  </li>
</ul>

<ul>
  <li><span>In the TMGMT demo module the <a href=\"";
        // line 39
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["file_translator"] ?? null), "html", null, true));
        echo "\">File translator</a> is enabled by default. It allows users to export and import texts via xliff and HTML. The workflow is the following:</span>

  <ul>
    <li>Submit a job to the File translator. The job is in \"active\" state.</li>
    <li>Export it as HTML/XLIFF format.</li>
    <li>Translate the content by editing the XLIFF files in plaintext or with a proper CAT tool.</li>
    <li>Import it back on the site.</li>
    <li>Review the job items/data items. XLIFF does not support a feedback loop or commenting an item. Improvements/fixings can only be done by the reviewer (or by reimporting the improved XLIFF).</li>
    <li>Press save as completed to accept the translation and finish the process.</li>
  </ul>
  </li>
</ul>

<ul>
  <li><span>In the TMGMT demo module the <a href=\"";
        // line 53
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["tmgmt_local"] ?? null), "html", null, true));
        echo "\">Drupal user</a> provider is also enabled by default. It allows to assign translation tasks to the users of the site that have the abilities to translate it (The demo adds all the abilities to all the users). The workflow is the following:</span>

  <ul>
    <li>Submit a job to the Drupal user provider and select translator for the job. The job is in \"active\" state.</li>
    <li>The user will translate the task. Also the task items can be reviewed.</li>
    <li>When the translation is done, the user will set the task as completed.</li>
    <li>Review the job items. This translator does not support a feedback loop or commenting an item. Improvements/fixings can only be done by the reviewer.</li>
    <li>Press save as completed to accept the translation and finish the process.</li>
  </ul>
  </li>
</ul>

<p>TMGMT demo also supports translation of paragraphs. To do this, you first need to enable paragraphs_demo and tmgmt_demo after that.</p>

<ul>
  <li><span>External translation services can be used for creating a foreign language version of the source text. These are the recommended translators:</span>

  <ul>
    <li><a href=\"https://www.drupal.org/project/tmgmt_microsoft\">Microsoft</a></li>
    <li><a href=\"https://www.drupal.org/project/tmgmt_google\">Google translate</a></li>
    <li><a href=\"https://www.drupal.org/project/tmgmt_mygengo\">Gengo</a></li>
    <li><a href=\"https://www.drupal.org/project/tmgmt_oht\">One Hour Translation</a></li>
  </ul>
  </li>
</ul>
";
    }

    public function getTemplateName()
    {
        return "modules/tmgmt/modules/demo/templates/tmgmt-demo-text.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 53,  79 => 39,  66 => 29,  60 => 26,  52 => 21,  47 => 19,  43 => 17,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/tmgmt/modules/demo/templates/tmgmt-demo-text.html.twig", "E:\\xampp\\htdocs\\drupal8\\modules\\tmgmt\\modules\\demo\\templates\\tmgmt-demo-text.html.twig");
    }
}
