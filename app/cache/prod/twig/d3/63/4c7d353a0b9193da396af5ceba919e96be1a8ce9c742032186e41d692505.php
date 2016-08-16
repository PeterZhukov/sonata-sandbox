<?php

/* AppBundle::demo_layout.html.twig */
class __TwigTemplate_d3634c7d353a0b9193da396af5ceba919e96be1a8ce9c742032186e41d692505 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 11
        $this->parent = $this->loadTemplate("SonataPageBundle::layout.html.twig", "AppBundle::demo_layout.html.twig", 11);
        $this->blocks = array(
            'sonata_page_body_tag' => array($this, 'block_sonata_page_body_tag'),
            'sonata_page_javascripts' => array($this, 'block_sonata_page_javascripts'),
            'sonata_page_container' => array($this, 'block_sonata_page_container'),
            'sonata_page_breadcrumb' => array($this, 'block_sonata_page_breadcrumb'),
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
    public function block_sonata_page_body_tag($context, array $blocks = array())
    {
        // line 14
        echo "    ";
        $this->displayParentBlock("sonata_page_body_tag", $context, $blocks);
        echo "

    ";
        // line 16
        $this->loadTemplate("SonataSeoBundle:Block:_facebook_sdk.html.twig", "AppBundle::demo_layout.html.twig", 16)->display($context);
        // line 17
        echo "    ";
        $this->loadTemplate("SonataSeoBundle:Block:_twitter_sdk.html.twig", "AppBundle::demo_layout.html.twig", 17)->display($context);
        // line 18
        echo "    ";
        $this->loadTemplate("SonataSeoBundle:Block:_pinterest_sdk.html.twig", "AppBundle::demo_layout.html.twig", 18)->display($context);
        // line 19
        echo "
";
    }

    // line 22
    public function block_sonata_page_javascripts($context, array $blocks = array())
    {
        // line 23
        echo "    <script type=\"text/javascript\">
        var basket_update_confirmation_message = '";
        // line 24
        echo twig_escape_filter($this->env, twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("sonata_basket_update_confirmation", array(), "SonataDemoBundle"), "js"), "html", null, true);
        echo "';
    </script>

    <script src=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assetic/sonata_front_js.js"), "html", null, true);
        echo "\" type=\"text/javascript\"></script>
";
    }

    // line 30
    public function block_sonata_page_container($context, array $blocks = array())
    {
        // line 31
        echo "    <div class=\"demonstration-bar\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("sonata.demo.demonstration.message", array(), "SonataDemoBundle"), "html", null, true);
        echo "</div>

    <a href=\"https://github.com/sonata-project\"><img style=\"position: absolute; top: 0; right: 0; border: 0;\" src=\"https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png\" alt=\"Fork me on GitHub\"></a>

    ";
        // line 35
        $this->displayParentBlock("sonata_page_container", $context, $blocks);
        echo "
";
    }

    // line 38
    public function block_sonata_page_breadcrumb($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "AppBundle::demo_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 38,  82 => 35,  74 => 31,  71 => 30,  65 => 27,  59 => 24,  56 => 23,  53 => 22,  48 => 19,  45 => 18,  42 => 17,  40 => 16,  34 => 14,  31 => 13,  11 => 11,);
    }
}
