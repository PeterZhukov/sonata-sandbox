<?php

/* SonataSeoBundle:Block:_pinterest_sdk.html.twig */
class __TwigTemplate_849d422302d374d7094587f75bdaae398be1173dbaad8584895602dfd5d136ac extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'pinterest_sdk' => array($this, 'block_pinterest_sdk'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 11
        $this->displayBlock('pinterest_sdk', $context, $blocks);
    }

    public function block_pinterest_sdk($context, array $blocks = array())
    {
        // line 12
        echo "    ";
        ob_start();
        // line 13
        echo "
        <script type=\"text/javascript\" async src=\"//assets.pinterest.com/js/pinit.js\"></script>

    ";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "SonataSeoBundle:Block:_pinterest_sdk.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  29 => 13,  26 => 12,  20 => 11,);
    }
}
