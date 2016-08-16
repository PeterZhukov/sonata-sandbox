<?php

/* SonataNewsBundle:Block:recent_comments.html.twig */
class __TwigTemplate_0f993e70c1b6729f1c5030bb1a31655716e855fad2097108d104bd0a61db5254 extends Sonata\CacheBundle\Twig\TwigTemplate14
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
        // line 11
        return $this->loadTemplate($this->getAttribute($this->getAttribute((isset($context["sonata_block"]) ? $context["sonata_block"] : null), "templates", array()), "block_base", array()), "SonataNewsBundle:Block:recent_comments.html.twig", 11);
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 13
    public function block_block($context, array $blocks = array())
    {
        // line 14
        echo "
    <div class=\"sonata-news-block-recent-comment box box-primary\">
        ";
        // line 16
        if ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "title", array())) {
            // line 17
            echo "            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">
                    <i class=\"fa fa-comments fa-fw\"></i> ";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "title", array()), "html", null, true);
            echo "
                </h3>
            </div>
        ";
        }
        // line 23
        echo "
        <div class=\"box-body\">
            ";
        // line 25
        // token for sonata_template_box, however the box is disabled
        // line 26
        echo "
            <div class=\"sonata-blog-post-container list-group\">
                ";
        // line 28
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["pager"]) ? $context["pager"] : null), "getResults", array(), "method"));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["comment"]) {
            // line 29
            echo "                    ";
            if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
                // line 30
                echo "                        <a class=\"list-group-item\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.news.admin.comment"), "method"), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($context["comment"], "id", array()))), "method"), "html", null, true);
                echo "\">
                            <span class=\"label label-";
                // line 31
                echo twig_escape_filter($this->env, $this->env->getExtension('sonata_core_status')->statusClass($context["comment"]), "html", null, true);
                echo "\">
                                ";
                // line 32
                if (($this->getAttribute($context["comment"], "status", array()) == twig_constant("Sonata\\NewsBundle\\Model\\CommentInterface::STATUS_INVALID"))) {
                    // line 33
                    echo "                                    ";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("label_comment_invalid", array(), "SonataNewsBundle"), "html", null, true);
                    echo "
                                ";
                } elseif (($this->getAttribute(                // line 34
$context["comment"], "status", array()) == twig_constant("Sonata\\NewsBundle\\Model\\CommentInterface::STATUS_VALID"))) {
                    // line 35
                    echo "                                    ";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("label_comment_valid", array(), "SonataNewsBundle"), "html", null, true);
                    echo "
                                ";
                } elseif (($this->getAttribute(                // line 36
$context["comment"], "status", array()) == twig_constant("Sonata\\NewsBundle\\Model\\CommentInterface::STATUS_MODERATE"))) {
                    // line 37
                    echo "                                    ";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("label_comment_moderate", array(), "SonataNewsBundle"), "html", null, true);
                    echo "
                                ";
                } else {
                    // line 39
                    echo "                                    ";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("label_unknown_status", array(), "SonataNewsBundle"), "html", null, true);
                    echo "
                                ";
                }
                // line 41
                echo "                            </span>&nbsp;

                            ";
                // line 43
                echo twig_escape_filter($this->env, $this->getAttribute($context["comment"], "name", array()), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, twig_truncate_filter($this->env, $this->getAttribute($context["comment"], "message", array()), 30), "html", null, true);
                echo "
                        </a>
                    ";
            } else {
                // line 46
                echo "                        <a class=\"list-group-item\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("sonata_news_view", array("permalink" => $this->env->getExtension('sonata_news')->generatePermalink($this->getAttribute($context["comment"], "post", array())))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["comment"], "name", array()), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, twig_truncate_filter($this->env, $this->getAttribute($context["comment"], "message", array()), 30), "html", null, true);
                echo "
                        </a>
                    ";
            }
            // line 49
            echo "                ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 50
            echo "                    <a href=\"#\">";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("no_comment_found", array(), "SonataNewsBundle"), "html", null, true);
            echo "</a>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comment'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        echo "            </div>
        </div>

        <div class=\"box-footer\">
            ";
        // line 56
        if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
            // line 57
            echo "                <a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.news.admin.comment"), "method"), "generateUrl", array(0 => "list"), "method"), "html", null, true);
            echo "\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-list\"></i> ";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("view_all_comments", array(), "SonataNewsBundle"), "html", null, true);
            echo "</a>
            ";
        }
        // line 59
        echo "        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "SonataNewsBundle:Block:recent_comments.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  155 => 59,  147 => 57,  145 => 56,  139 => 52,  130 => 50,  125 => 49,  114 => 46,  106 => 43,  102 => 41,  96 => 39,  90 => 37,  88 => 36,  83 => 35,  81 => 34,  76 => 33,  74 => 32,  70 => 31,  65 => 30,  62 => 29,  57 => 28,  53 => 26,  51 => 25,  47 => 23,  40 => 19,  36 => 17,  34 => 16,  30 => 14,  27 => 13,  18 => 11,);
    }
}
