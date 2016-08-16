<?php

/* SonataBasketBundle:Block:block_basket_items.html.twig */
class __TwigTemplate_3fb91ea7ed85eef5a928cb2f840838007eafe505f6cd52edbcfd4a085f1f70df extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'block' => array($this, 'block_block'),
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return $this->loadTemplate($this->getAttribute($this->getAttribute((isset($context["sonata_block"]) ? $context["sonata_block"] : null), "templates", array()), "block_base", array()), "SonataBasketBundle:Block:block_basket_items.html.twig", 1);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_block($context, array $blocks = array())
    {
        // line 4
        echo "    <div style=\"display:inline; margin-left:10px;\">
        <span class=\"glyphicon glyphicon-shopping-cart\"></span>
        <a href=\"";
        // line 6
        echo $this->env->getExtension('routing')->getPath("sonata_basket_index");
        echo "\">
            ";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("sonata.basket.title_basket", array(), "SonataBasketBundle"), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["sonata_basket"]) ? $context["sonata_basket"] : null), "basket", array()), "countBasketElements", array()), "html", null, true);
        echo ")
        </a>
    </div>
";
    }

    public function getTemplateName()
    {
        return "SonataBasketBundle:Block:block_basket_items.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 7,  34 => 6,  30 => 4,  27 => 3,  18 => 1,);
    }
}
