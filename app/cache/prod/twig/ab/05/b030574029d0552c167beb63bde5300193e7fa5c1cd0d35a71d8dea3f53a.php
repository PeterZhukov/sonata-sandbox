<?php

/* SonataPageBundle:Block:block_container.html.twig */
class __TwigTemplate_ab05b030574029d0552c167beb63bde5300193e7fa5c1cd0d35a71d8dea3f53a extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 12
        $this->parent = $this->loadTemplate("SonataBlockBundle:Block:block_container.html.twig", "SonataPageBundle:Block:block_container.html.twig", 12);
        $this->blocks = array(
            'block_child_render' => array($this, 'block_block_child_render'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataBlockBundle:Block:block_container.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 14
    public function block_block_child_render($context, array $blocks = array())
    {
        // line 15
        echo "    ";
        echo $this->env->getExtension('sonata_page')->renderBlock((isset($context["child"]) ? $context["child"] : null));
        echo "
";
    }

    public function getTemplateName()
    {
        return "SonataPageBundle:Block:block_container.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 15,  28 => 14,  11 => 12,);
    }
}
