<?php

/* SonataProductBundle:Block:recent_products.html.twig */
class __TwigTemplate_fb552eed967aa63a836c3320ba737873ec92ae33da5b863bb34a772afede5586 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 11
        $this->parent = $this->loadTemplate("SonataProductBundle:Block:_base_products_block.html.twig", "SonataProductBundle:Block:recent_products.html.twig", 11);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataProductBundle:Block:_base_products_block.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "SonataProductBundle:Block:recent_products.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  11 => 11,);
    }
}
