<?php

/* SonataProductBundle:Catalog:_product_grid.html.twig */
class __TwigTemplate_7f52a680ad4eb178a86d08f3ec64aa24887ee0618be40d918c3c74cc23e6eb74 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 12
        $this->parent = $this->loadTemplate("SonataProductBundle:Product:view_thumbnail.html.twig", "SonataProductBundle:Catalog:_product_grid.html.twig", 12);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataProductBundle:Product:view_thumbnail.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "SonataProductBundle:Catalog:_product_grid.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  11 => 12,);
    }
}
