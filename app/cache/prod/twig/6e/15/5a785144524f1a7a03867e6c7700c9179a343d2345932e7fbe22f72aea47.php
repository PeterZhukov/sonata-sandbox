<?php

/* SonataPageBundle::2columns_layout.html.twig */
class __TwigTemplate_6e155a785144524f1a7a03867e6c7700c9179a343d2345932e7fbe22f72aea47 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 11
        $this->parent = $this->loadTemplate("SonataPageBundle::layout.html.twig", "SonataPageBundle::2columns_layout.html.twig", 11);
        $this->blocks = array(
            'page_content' => array($this, 'block_page_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataPageBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 13
    public function block_page_content($context, array $blocks = array())
    {
        // line 14
        echo "    ";
        if (array_key_exists("page", $context)) {
            // line 15
            echo "        <div class=\"span6\">
            ";
            // line 16
            if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "name", array()) != "global")) {
                // line 17
                echo "                ";
                echo $this->env->getExtension('sonata_page')->renderContainer("left_col", "global");
                echo "
            ";
            }
            // line 19
            echo "            ";
            echo $this->env->getExtension('sonata_page')->renderContainer("left_col", (isset($context["page"]) ? $context["page"] : null));
            echo "
        </div>
        <div class=\"span6\">
            ";
            // line 22
            if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "name", array()) != "global")) {
                // line 23
                echo "                ";
                echo $this->env->getExtension('sonata_page')->renderContainer("right_col", "global");
                echo "
            ";
            }
            // line 25
            echo "            ";
            echo $this->env->getExtension('sonata_page')->renderContainer("right_col", (isset($context["page"]) ? $context["page"] : null));
            echo "
        </div>
        <div style=\"clear: both\"></div>
    ";
        }
        // line 29
        echo "
    ";
        // line 30
        $this->displayParentBlock("page_content", $context, $blocks);
        echo "

";
    }

    public function getTemplateName()
    {
        return "SonataPageBundle::2columns_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 30,  68 => 29,  60 => 25,  54 => 23,  52 => 22,  45 => 19,  39 => 17,  37 => 16,  34 => 15,  31 => 14,  28 => 13,  11 => 11,);
    }
}
