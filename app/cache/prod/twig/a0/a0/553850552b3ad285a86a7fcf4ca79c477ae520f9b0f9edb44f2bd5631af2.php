<?php

/* SonataNewsBundle:Admin:inner_row_comment.html.twig */
class __TwigTemplate_a0a0553850552b3ad285a86a7fcf4ca79c477ae520f9b0f9edb44f2bd5631af2 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 12
        $this->parent = $this->loadTemplate("SonataAdminBundle:CRUD:base_list_flat_inner_row.html.twig", "SonataNewsBundle:Admin:inner_row_comment.html.twig", 12);
        $this->blocks = array(
            'row' => array($this, 'block_row'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataAdminBundle:CRUD:base_list_flat_inner_row.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 14
    public function block_row($context, array $blocks = array())
    {
        // line 15
        echo "
    ";
        // line 16
        if (($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method") == "valid")) {
            // line 17
            echo "        <span class=\"label label-success\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method"), "html", null, true);
            echo "</span>
    ";
        } elseif (($this->getAttribute(        // line 18
(isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method") == "invalid")) {
            // line 19
            echo "        <span class=\"label label-danger\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method"), "html", null, true);
            echo "</span>
    ";
        } elseif (($this->getAttribute(        // line 20
(isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method") == "moderate")) {
            // line 21
            echo "        <span class=\"label label-warning\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method"), "html", null, true);
            echo "</span>
    ";
        } else {
            // line 23
            echo "        <span class=\"label\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "getStatusCode", array(), "method"), "html", null, true);
            echo "</span>
    ";
        }
        // line 25
        echo "
    ";
        // line 26
        echo $this->env->getExtension('sonata_admin')->renderListElement((isset($context["object"]) ? $context["object"] : null), $this->getAttribute($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "list", array()), "name", array(), "array"));
        echo " -
    ";
        // line 27
        echo $this->env->getExtension('sonata_admin')->renderListElement((isset($context["object"]) ? $context["object"] : null), $this->getAttribute($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "list", array()), "url", array(), "array"));
        echo " -
    ";
        // line 28
        echo $this->env->getExtension('sonata_admin')->renderListElement((isset($context["object"]) ? $context["object"] : null), $this->getAttribute($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "list", array()), "email", array(), "array"));
        echo " <br />

    <small>
        ";
        // line 31
        echo $this->env->getExtension('sonata_admin')->renderListElement((isset($context["object"]) ? $context["object"] : null), $this->getAttribute($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "list", array()), "message", array(), "array"));
        echo "
    </small>

";
    }

    public function getTemplateName()
    {
        return "SonataNewsBundle:Admin:inner_row_comment.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 31,  73 => 28,  69 => 27,  65 => 26,  62 => 25,  56 => 23,  50 => 21,  48 => 20,  43 => 19,  41 => 18,  36 => 17,  34 => 16,  31 => 15,  28 => 14,  11 => 12,);
    }
}
