<?php

/* SonataSeoBundle:Block:breadcrumb.html.twig */
class __TwigTemplate_35e71857a424504e4b714de9a20e6c37027bc96418fa94d0f3aa5e7bf43f91a1 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 12
        $this->parent = $this->loadTemplate("knp_menu_ordered.html.twig", "SonataSeoBundle:Block:breadcrumb.html.twig", 12);
        $this->blocks = array(
            'label' => array($this, 'block_label'),
            'list' => array($this, 'block_list'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "knp_menu_ordered.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 13
    public function block_label($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "label", array()), $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "getExtra", array(0 => "translation_params", 1 => array()), "method"), $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "getExtra", array(0 => "translation_domain", 1 => "SonataSeoBundle"), "method")), "html", null, true);
    }

    // line 15
    public function block_list($context, array $blocks = array())
    {
        // line 16
        ob_start();
        // line 17
        echo "    <div class=\"sonata_breadcrumb\">
        ";
        // line 18
        $this->displayParentBlock("list", $context, $blocks);
        echo "
    </div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "SonataSeoBundle:Block:breadcrumb.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 18,  40 => 17,  38 => 16,  35 => 15,  29 => 13,  11 => 12,);
    }
}
