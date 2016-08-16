<?php

/* SonataPageBundle::layout.html.twig */
class __TwigTemplate_a41619823edda75888d791dea69856682754bef2d049b170c6df6d24116191fb extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 11
        $this->parent = $this->loadTemplate("SonataPageBundle::base_layout.html.twig", "SonataPageBundle::layout.html.twig", 11);
        $this->blocks = array(
            'sonata_page_container' => array($this, 'block_sonata_page_container'),
            'sonata_page_breadcrumb' => array($this, 'block_sonata_page_breadcrumb'),
            'page_content' => array($this, 'block_page_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataPageBundle::base_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 13
    public function block_sonata_page_container($context, array $blocks = array())
    {
        // line 14
        echo "    <div class=\"container\">
        <div class=\"content\">
            <div class=\"row page-header\">
                ";
        // line 17
        echo $this->env->getExtension('sonata_page')->renderContainer("header", "global");
        echo "
            </div>

            ";
        // line 20
        $this->displayBlock('sonata_page_breadcrumb', $context, $blocks);
        // line 28
        echo "
            ";
        // line 29
        if (array_key_exists("page", $context)) {
            // line 30
            echo "                <div class=\"row\">
                    ";
            // line 31
            if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "name", array()) != "global")) {
                // line 32
                echo "                        ";
                echo $this->env->getExtension('sonata_page')->renderContainer("content_top", "global");
                echo "
                    ";
            }
            // line 34
            echo "                    ";
            echo $this->env->getExtension('sonata_page')->renderContainer("content_top", (isset($context["page"]) ? $context["page"] : null));
            echo "
                </div>
            ";
        }
        // line 37
        echo "
            <div class=\"row\">
                ";
        // line 39
        $this->displayBlock('page_content', $context, $blocks);
        // line 51
        echo "            </div>

            ";
        // line 53
        if (array_key_exists("page", $context)) {
            // line 54
            echo "                <div class=\"row\">
                    ";
            // line 55
            echo $this->env->getExtension('sonata_page')->renderContainer("content_bottom", (isset($context["page"]) ? $context["page"] : null));
            echo "

                    ";
            // line 57
            if (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "name", array()) != "global")) {
                // line 58
                echo "                        ";
                echo $this->env->getExtension('sonata_page')->renderContainer("content_bottom", "global");
                echo "
                    ";
            }
            // line 60
            echo "                </div>
            ";
        }
        // line 62
        echo "        </div>

        <footer class=\"row\">
            ";
        // line 65
        echo $this->env->getExtension('sonata_page')->renderContainer("footer", "global");
        echo "
        </footer>
    </div>
";
    }

    // line 20
    public function block_sonata_page_breadcrumb($context, array $blocks = array())
    {
        // line 21
        echo "                <div class=\"row\">
                    ";
        // line 22
        if ( !array_key_exists("sonata_seo_context", $context)) {
            // line 23
            echo "                        ";
            $context["sonata_seo_context"] = "homepage";
            // line 24
            echo "                    ";
        }
        // line 25
        echo "                    ";
        echo call_user_func_array($this->env->getFunction('sonata_block_render_event')->getCallable(), array("breadcrumb", array("context" => (isset($context["sonata_seo_context"]) ? $context["sonata_seo_context"] : null), "current_uri" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "requestUri", array()))));
        echo "
                </div>
            ";
    }

    // line 39
    public function block_page_content($context, array $blocks = array())
    {
        // line 40
        echo "                    ";
        if (array_key_exists("content", $context)) {
            // line 41
            echo "                        ";
            echo (isset($context["content"]) ? $context["content"] : null);
            echo "
                    ";
        } else {
            // line 43
            echo "                        ";
            $context["content"] = $this->renderBlock("content", $context, $blocks);
            // line 44
            echo "                        ";
            if ((twig_length_filter($this->env, (isset($context["content"]) ? $context["content"] : null)) > 0)) {
                // line 45
                echo "                            ";
                echo (isset($context["content"]) ? $context["content"] : null);
                echo "
                        ";
            } elseif (            // line 46
array_key_exists("page", $context)) {
                // line 47
                echo "                            ";
                echo $this->env->getExtension('sonata_page')->renderContainer("content", (isset($context["page"]) ? $context["page"] : null));
                echo "
                        ";
            }
            // line 49
            echo "                    ";
        }
        // line 50
        echo "                ";
    }

    public function getTemplateName()
    {
        return "SonataPageBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  170 => 50,  167 => 49,  161 => 47,  159 => 46,  154 => 45,  151 => 44,  148 => 43,  142 => 41,  139 => 40,  136 => 39,  128 => 25,  125 => 24,  122 => 23,  120 => 22,  117 => 21,  114 => 20,  106 => 65,  101 => 62,  97 => 60,  91 => 58,  89 => 57,  84 => 55,  81 => 54,  79 => 53,  75 => 51,  73 => 39,  69 => 37,  62 => 34,  56 => 32,  54 => 31,  51 => 30,  49 => 29,  46 => 28,  44 => 20,  38 => 17,  33 => 14,  30 => 13,  11 => 11,);
    }
}
