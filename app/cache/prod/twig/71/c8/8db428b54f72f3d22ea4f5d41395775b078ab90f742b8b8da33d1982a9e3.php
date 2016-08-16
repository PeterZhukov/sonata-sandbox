<?php

/* SonataNewsBundle:Block:recent_posts.html.twig */
class __TwigTemplate_71c88db428b54f72f3d22ea4f5d41395775b078ab90f742b8b8da33d1982a9e3 extends Sonata\CacheBundle\Twig\TwigTemplate14
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
        return $this->loadTemplate($this->getAttribute($this->getAttribute((isset($context["sonata_block"]) ? $context["sonata_block"] : null), "templates", array()), "block_base", array()), "SonataNewsBundle:Block:recent_posts.html.twig", 11);
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
    <div class=\"sonata-news-block-recent-post box box-primary\">
        <div class=\"box-header with-border\">
            <h3 class=\"box-title\">
                <i class=\"fa fa-pencil\"></i> ";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "title", array()), "html", null, true);
        echo "
            </h3>
        </div>

        <div class=\"box-body\">
            ";
        // line 23
        // token for sonata_template_box, however the box is disabled
        // line 24
        echo "
            <div class=\"sonata-blog-post-container list-group\">
                ";
        // line 26
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["pager"]) ? $context["pager"] : null), "getResults", array(), "method"));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 27
            echo "                    ";
            if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
                // line 28
                echo "                        <a class=\"list-group-item\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.news.admin.post"), "method"), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($context["post"], "id", array()))), "method"), "html", null, true);
                echo "\">
                            ";
                // line 29
                if ($this->getAttribute($context["post"], "ispublic", array())) {
                    // line 30
                    echo "                            <span class=\"label label-success\">";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("post_is_public", array(), "SonataNewsBundle"), "html", null, true);
                    echo "</span>
                        ";
                } else {
                    // line 32
                    echo "                            <span class=\"label\">";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("post_is_not_public", array(), "SonataNewsBundle"), "html", null, true);
                    echo "</span>
                            ";
                }
                // line 33
                echo "&nbsp;

                            ";
                // line 35
                echo twig_escape_filter($this->env, $this->getAttribute($context["post"], "title", array()), "html", null, true);
                echo " - ";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("archive_author", array("%author%" => $this->getAttribute($context["post"], "author", array())), "SonataNewsBundle"), "html", null, true);
                echo " - ";
                echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute($context["post"], "publicationDateStart", array()));
                echo "</a>
                    ";
            } else {
                // line 37
                echo "                        <a class=\"list-group-item\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("sonata_news_view", array("permalink" => $this->env->getExtension('sonata_news')->generatePermalink($context["post"]))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["post"], "title", array()), "html", null, true);
                echo "</a> - ";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("archive_author", array("%author%" => $this->getAttribute($context["post"], "author", array())), "SonataNewsBundle"), "html", null, true);
                echo " - ";
                echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute($context["post"], "publicationDateStart", array()));
                echo "
                    ";
            }
            // line 39
            echo "                ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 40
            echo "                    <a class=\"list-group-item\" href=\"#\">";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("no_post_found", array(), "SonataNewsBundle"), "html", null, true);
            echo "</a>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "            </div>
        </div>

        <div class=\"box-footer\">
            ";
        // line 46
        if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
            // line 47
            echo "                <a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.news.admin.post"), "method"), "generateUrl", array(0 => "list"), "method"), "html", null, true);
            echo "\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-list\"></i> ";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("view_all_posts", array(), "SonataNewsBundle"), "html", null, true);
            echo "</a>
            ";
        } else {
            // line 49
            echo "                <a href=\"";
            echo $this->env->getExtension('routing')->getUrl("sonata_news_archive");
            echo "\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-list\"></i> ";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("view_all_posts", array(), "SonataNewsBundle"), "html", null, true);
            echo "</a>
            ";
        }
        // line 51
        echo "        </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "SonataNewsBundle:Block:recent_posts.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  140 => 51,  132 => 49,  124 => 47,  122 => 46,  116 => 42,  107 => 40,  102 => 39,  90 => 37,  81 => 35,  77 => 33,  71 => 32,  65 => 30,  63 => 29,  58 => 28,  55 => 27,  50 => 26,  46 => 24,  44 => 23,  36 => 18,  30 => 14,  27 => 13,  18 => 11,);
    }
}
