<?php

/* SonataAdminBundle::standard_layout.html.twig */
class __TwigTemplate_39c2a7bc7cd2e1ba427e05dade22e05b9001e58ae403295b40c99f3a086a2be1 extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'html_attributes' => array($this, 'block_html_attributes'),
            'meta_tags' => array($this, 'block_meta_tags'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
            'sonata_head_title' => array($this, 'block_sonata_head_title'),
            'body_attributes' => array($this, 'block_body_attributes'),
            'sonata_header' => array($this, 'block_sonata_header'),
            'sonata_header_noscript_warning' => array($this, 'block_sonata_header_noscript_warning'),
            'logo' => array($this, 'block_logo'),
            'sonata_nav' => array($this, 'block_sonata_nav'),
            'sonata_breadcrumb' => array($this, 'block_sonata_breadcrumb'),
            'sonata_top_nav_menu' => array($this, 'block_sonata_top_nav_menu'),
            'sonata_wrapper' => array($this, 'block_sonata_wrapper'),
            'sonata_left_side' => array($this, 'block_sonata_left_side'),
            'sonata_side_nav' => array($this, 'block_sonata_side_nav'),
            'sonata_sidebar_search' => array($this, 'block_sonata_sidebar_search'),
            'side_bar_before_nav' => array($this, 'block_side_bar_before_nav'),
            'side_bar_nav' => array($this, 'block_side_bar_nav'),
            'side_bar_after_nav' => array($this, 'block_side_bar_after_nav'),
            'sonata_page_content' => array($this, 'block_sonata_page_content'),
            'sonata_page_content_header' => array($this, 'block_sonata_page_content_header'),
            'sonata_page_content_nav' => array($this, 'block_sonata_page_content_nav'),
            'tab_menu_navbar_header' => array($this, 'block_tab_menu_navbar_header'),
            'sonata_admin_content' => array($this, 'block_sonata_admin_content'),
            'notice' => array($this, 'block_notice'),
            'bootlint' => array($this, 'block_bootlint'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 11
        $context["_preview"] = $this->renderBlock("preview", $context, $blocks);
        // line 12
        $context["_form"] = $this->renderBlock("form", $context, $blocks);
        // line 13
        $context["_show"] = $this->renderBlock("show", $context, $blocks);
        // line 14
        $context["_list_table"] = $this->renderBlock("list_table", $context, $blocks);
        // line 15
        $context["_list_filters"] = $this->renderBlock("list_filters", $context, $blocks);
        // line 16
        $context["_tab_menu"] = $this->renderBlock("tab_menu", $context, $blocks);
        // line 17
        $context["_content"] = $this->renderBlock("content", $context, $blocks);
        // line 18
        $context["_title"] = $this->renderBlock("title", $context, $blocks);
        // line 19
        $context["_breadcrumb"] = $this->renderBlock("breadcrumb", $context, $blocks);
        // line 20
        $context["_actions"] = $this->renderBlock("actions", $context, $blocks);
        // line 21
        $context["_navbar_title"] = $this->renderBlock("navbar_title", $context, $blocks);
        // line 22
        $context["_list_filters_actions"] = $this->renderBlock("list_filters_actions", $context, $blocks);
        // line 23
        echo "
<!DOCTYPE html>
<html ";
        // line 25
        $this->displayBlock('html_attributes', $context, $blocks);
        echo ">
    <head>
        ";
        // line 27
        $this->displayBlock('meta_tags', $context, $blocks);
        // line 32
        echo "
        ";
        // line 33
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 40
        echo "
        ";
        // line 41
        $this->displayBlock('javascripts', $context, $blocks);
        // line 82
        echo "
        <title>
        ";
        // line 84
        $this->displayBlock('sonata_head_title', $context, $blocks);
        // line 104
        echo "        </title>
    </head>
    <body ";
        // line 106
        $this->displayBlock('body_attributes', $context, $blocks);
        echo ">

    <div class=\"wrapper\">

        ";
        // line 110
        $this->displayBlock('sonata_header', $context, $blocks);
        // line 195
        echo "
        ";
        // line 196
        $this->displayBlock('sonata_wrapper', $context, $blocks);
        // line 324
        echo "    </div>

    ";
        // line 326
        if ((array_key_exists("admin_pool", $context) && $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "use_bootlint"), "method"))) {
            // line 327
            echo "        ";
            $this->displayBlock('bootlint', $context, $blocks);
            // line 333
            echo "    ";
        }
        // line 334
        echo "
    </body>
</html>
";
    }

    // line 25
    public function block_html_attributes($context, array $blocks = array())
    {
        echo "class=\"no-js\"";
    }

    // line 27
    public function block_meta_tags($context, array $blocks = array())
    {
        // line 28
        echo "            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
            <meta charset=\"UTF-8\">
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        ";
    }

    // line 33
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 34
        echo "            ";
        if (array_key_exists("admin_pool", $context)) {
            // line 35
            echo "                ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "stylesheets", 1 => array()), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["stylesheet"]) {
                // line 36
                echo "                        <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl($context["stylesheet"]), "html", null, true);
                echo "\">
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stylesheet'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 38
            echo "            ";
        }
        // line 39
        echo "        ";
    }

    // line 41
    public function block_javascripts($context, array $blocks = array())
    {
        // line 42
        echo "            <script>
                window.SONATA_CONFIG = {
                    CONFIRM_EXIT: ";
        // line 44
        if ((array_key_exists("admin_pool", $context) && $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "confirm_exit"), "method"))) {
            echo "true";
        } else {
            echo "false";
        }
        echo ",
                    USE_SELECT2: ";
        // line 45
        if ((array_key_exists("admin_pool", $context) && $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "use_select2"), "method"))) {
            echo "true";
        } else {
            echo "false";
        }
        echo ",
                    USE_ICHECK: ";
        // line 46
        if ((array_key_exists("admin_pool", $context) && $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "use_icheck"), "method"))) {
            echo "true";
        } else {
            echo "false";
        }
        // line 47
        echo "                };
                window.SONATA_TRANSLATIONS = {
                    CONFIRM_EXIT:  '";
        // line 49
        echo twig_escape_filter($this->env, twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("confirm_exit", array(), "SonataAdminBundle"), "js"), "html", null, true);
        echo "'
                };

                // http://getbootstrap.com/getting-started/#support-ie10-width
                if (navigator.userAgent.match(/IEMobile\\/10\\.0/)) {
                    var msViewportStyle = document.createElement('style');
                    msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));
                    document.querySelector('head').appendChild(msViewportStyle);
                }
            </script>

            ";
        // line 60
        if (array_key_exists("admin_pool", $context)) {
            // line 61
            echo "                ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "javascripts", 1 => array()), "method"));
            foreach ($context['_seq'] as $context["_key"] => $context["javascript"]) {
                // line 62
                echo "                    <script src=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl($context["javascript"]), "html", null, true);
                echo "\"></script>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['javascript'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            echo "            ";
        }
        // line 65
        echo "
            ";
        // line 66
        $context["locale"] = $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "locale", array());
        // line 67
        echo "            ";
        // line 68
        echo "            ";
        if ((twig_slice($this->env, (isset($context["locale"]) ? $context["locale"] : null), 0, 2) != "en")) {
            // line 69
            echo "                <script src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl((("bundles/sonatacore/vendor/moment/locale/" . strtr((isset($context["locale"]) ? $context["locale"] : null), array("_" => "-"))) . ".js")), "html", null, true);
            echo "\"></script>
            ";
        }
        // line 71
        echo "
            ";
        // line 73
        echo "            ";
        if ((array_key_exists("admin_pool", $context) && $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "use_select2"), "method"))) {
            // line 74
            echo "                ";
            if (((isset($context["locale"]) ? $context["locale"] : null) == "pt")) {
                $context["locale"] = "pt_PT";
            }
            // line 75
            echo "
                ";
            // line 77
            echo "                ";
            if ((twig_slice($this->env, (isset($context["locale"]) ? $context["locale"] : null), 0, 2) != "en")) {
                // line 78
                echo "                    <script src=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl((("bundles/sonatacore/vendor/select2/select2_locale_" . strtr((isset($context["locale"]) ? $context["locale"] : null), array("_" => "-"))) . ".js")), "html", null, true);
                echo "\"></script>
                ";
            }
            // line 80
            echo "            ";
        }
        // line 81
        echo "        ";
    }

    // line 84
    public function block_sonata_head_title($context, array $blocks = array())
    {
        // line 85
        echo "            ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Admin", array(), "SonataAdminBundle"), "html", null, true);
        echo "

            ";
        // line 87
        if ( !twig_test_empty((isset($context["_title"]) ? $context["_title"] : null))) {
            // line 88
            echo "                ";
            echo (isset($context["_title"]) ? $context["_title"] : null);
            echo "
            ";
        } else {
            // line 90
            echo "                ";
            if (array_key_exists("action", $context)) {
                // line 91
                echo "                    -
                    ";
                // line 92
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "breadcrumbs", array(0 => (isset($context["action"]) ? $context["action"] : null)), "method"));
                $context['loop'] = array(
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                );
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["menu"]) {
                    // line 93
                    echo "                        ";
                    if ( !$this->getAttribute($context["loop"], "first", array())) {
                        // line 94
                        echo "                            ";
                        if (($this->getAttribute($context["loop"], "index", array()) != 2)) {
                            // line 95
                            echo "                                &gt;
                            ";
                        }
                        // line 97
                        echo "
                            ";
                        // line 98
                        echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "label", array()), "html", null, true);
                        echo "
                        ";
                    }
                    // line 100
                    echo "                    ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menu'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 101
                echo "                ";
            }
            // line 102
            echo "            ";
        }
        // line 103
        echo "        ";
    }

    // line 106
    public function block_body_attributes($context, array $blocks = array())
    {
        echo "class=\"sonata-bc skin-black fixed\"";
    }

    // line 110
    public function block_sonata_header($context, array $blocks = array())
    {
        // line 111
        echo "            <header class=\"main-header\">
                ";
        // line 112
        $this->displayBlock('sonata_header_noscript_warning', $context, $blocks);
        // line 119
        echo "                ";
        $this->displayBlock('logo', $context, $blocks);
        // line 133
        echo "                ";
        $this->displayBlock('sonata_nav', $context, $blocks);
        // line 193
        echo "            </header>
        ";
    }

    // line 112
    public function block_sonata_header_noscript_warning($context, array $blocks = array())
    {
        // line 113
        echo "                    <noscript>
                        <div class=\"noscript-warning\">
                            ";
        // line 115
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("noscript_warning", array(), "SonataAdminBundle"), "html", null, true);
        echo "
                        </div>
                    </noscript>
                ";
    }

    // line 119
    public function block_logo($context, array $blocks = array())
    {
        // line 120
        echo "                    ";
        if (array_key_exists("admin_pool", $context)) {
            // line 121
            echo "                        ";
            ob_start();
            // line 122
            echo "                            <a class=\"logo\" href=\"";
            echo $this->env->getExtension('routing')->getPath("sonata_admin_dashboard");
            echo "\">
                                ";
            // line 123
            if ((("single_image" == $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "title_mode"), "method")) || ("both" == $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "title_mode"), "method")))) {
                // line 124
                echo "                                    <img src=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "titlelogo", array())), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "title", array()), "html", null, true);
                echo "\">
                                ";
            }
            // line 126
            echo "                                ";
            if ((("single_text" == $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "title_mode"), "method")) || ("both" == $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getOption", array(0 => "title_mode"), "method")))) {
                // line 127
                echo "                                    <span>";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "title", array()), "html", null, true);
                echo "</span>
                                ";
            }
            // line 129
            echo "                            </a>
                        ";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
            // line 131
            echo "                    ";
        }
        // line 132
        echo "                ";
    }

    // line 133
    public function block_sonata_nav($context, array $blocks = array())
    {
        // line 134
        echo "                    ";
        if (array_key_exists("admin_pool", $context)) {
            // line 135
            echo "                        <nav class=\"navbar navbar-static-top\" role=\"navigation\">
                            <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
                                <span class=\"sr-only\">Toggle navigation</span>
                            </a>

                            <div class=\"navbar-left\">
                                ";
            // line 141
            $this->displayBlock('sonata_breadcrumb', $context, $blocks);
            // line 168
            echo "                            </div>

                            ";
            // line 170
            $this->displayBlock('sonata_top_nav_menu', $context, $blocks);
            // line 190
            echo "                        </nav>
                    ";
        }
        // line 192
        echo "                ";
    }

    // line 141
    public function block_sonata_breadcrumb($context, array $blocks = array())
    {
        // line 142
        echo "                                    <div class=\"hidden-xs\">
                                        ";
        // line 143
        if (( !twig_test_empty((isset($context["_breadcrumb"]) ? $context["_breadcrumb"] : null)) || array_key_exists("action", $context))) {
            // line 144
            echo "                                            <ol class=\"nav navbar-top-links breadcrumb\">
                                                ";
            // line 145
            if (twig_test_empty((isset($context["_breadcrumb"]) ? $context["_breadcrumb"] : null))) {
                // line 146
                echo "                                                    ";
                if (array_key_exists("action", $context)) {
                    // line 147
                    echo "                                                        ";
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "breadcrumbs", array(0 => (isset($context["action"]) ? $context["action"] : null)), "method"));
                    $context['loop'] = array(
                      'parent' => $context['_parent'],
                      'index0' => 0,
                      'index'  => 1,
                      'first'  => true,
                    );
                    if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                        $length = count($context['_seq']);
                        $context['loop']['revindex0'] = $length - 1;
                        $context['loop']['revindex'] = $length;
                        $context['loop']['length'] = $length;
                        $context['loop']['last'] = 1 === $length;
                    }
                    foreach ($context['_seq'] as $context["_key"] => $context["menu"]) {
                        // line 148
                        echo "                                                            ";
                        if ( !$this->getAttribute($context["loop"], "last", array())) {
                            // line 149
                            echo "                                                                <li>
                                                                    ";
                            // line 150
                            if ( !twig_test_empty($this->getAttribute($context["menu"], "uri", array()))) {
                                // line 151
                                echo "                                                                        <a href=\"";
                                echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "uri", array()), "html", null, true);
                                echo "\">";
                                echo $this->getAttribute($context["menu"], "label", array());
                                echo "</a>
                                                                    ";
                            } else {
                                // line 153
                                echo "                                                                        ";
                                echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "label", array()), "html", null, true);
                                echo "
                                                                    ";
                            }
                            // line 155
                            echo "                                                                </li>
                                                            ";
                        } else {
                            // line 157
                            echo "                                                                <li class=\"active\"><span>";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "label", array()), "html", null, true);
                            echo "</span></li>
                                                            ";
                        }
                        // line 159
                        echo "                                                        ";
                        ++$context['loop']['index0'];
                        ++$context['loop']['index'];
                        $context['loop']['first'] = false;
                        if (isset($context['loop']['length'])) {
                            --$context['loop']['revindex0'];
                            --$context['loop']['revindex'];
                            $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menu'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 160
                    echo "                                                    ";
                }
                // line 161
                echo "                                                ";
            } else {
                // line 162
                echo "                                                    ";
                echo (isset($context["_breadcrumb"]) ? $context["_breadcrumb"] : null);
                echo "
                                                ";
            }
            // line 164
            echo "                                            </ol>
                                        ";
        }
        // line 166
        echo "                                    </div>
                                ";
    }

    // line 170
    public function block_sonata_top_nav_menu($context, array $blocks = array())
    {
        // line 171
        echo "                                <div class=\"navbar-custom-menu\">
                                    <ul class=\"nav navbar-nav\">
                                        <li class=\"dropdown\">
                                            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                                                <i class=\"fa fa-plus-square fa-fw\"></i> <i class=\"fa fa-caret-down\"></i>
                                            </a>
                                            ";
        // line 177
        $this->loadTemplate($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getTemplate", array(0 => "add_block"), "method"), "SonataAdminBundle::standard_layout.html.twig", 177)->display($context);
        // line 178
        echo "                                        </li>
                                        <li class=\"dropdown user-menu\">
                                            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                                                <i class=\"fa fa-user fa-fw\"></i> <i class=\"fa fa-caret-down\"></i>
                                            </a>
                                            <ul class=\"dropdown-menu dropdown-user\">
                                                ";
        // line 184
        $this->loadTemplate($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getTemplate", array(0 => "user_block"), "method"), "SonataAdminBundle::standard_layout.html.twig", 184)->display($context);
        // line 185
        echo "                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            ";
    }

    // line 196
    public function block_sonata_wrapper($context, array $blocks = array())
    {
        // line 197
        echo "            ";
        $this->displayBlock('sonata_left_side', $context, $blocks);
        // line 229
        echo "
            <div class=\"content-wrapper\">
                ";
        // line 231
        $this->displayBlock('sonata_page_content', $context, $blocks);
        // line 322
        echo "            </div>
        ";
    }

    // line 197
    public function block_sonata_left_side($context, array $blocks = array())
    {
        // line 198
        echo "                <aside class=\"main-sidebar\">
                    <section class=\"sidebar\">
                        ";
        // line 200
        $this->displayBlock('sonata_side_nav', $context, $blocks);
        // line 226
        echo "                    </section>
                </aside>
            ";
    }

    // line 200
    public function block_sonata_side_nav($context, array $blocks = array())
    {
        // line 201
        echo "                            ";
        $this->displayBlock('sonata_sidebar_search', $context, $blocks);
        // line 215
        echo "
                            ";
        // line 216
        $this->displayBlock('side_bar_before_nav', $context, $blocks);
        // line 217
        echo "                            ";
        $this->displayBlock('side_bar_nav', $context, $blocks);
        // line 222
        echo "                            ";
        $this->displayBlock('side_bar_after_nav', $context, $blocks);
        // line 225
        echo "                        ";
    }

    // line 201
    public function block_sonata_sidebar_search($context, array $blocks = array())
    {
        // line 202
        echo "                                ";
        if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "security", array()), "token", array()) && $this->env->getExtension('security')->isGranted("ROLE_SONATA_ADMIN"))) {
            // line 203
            echo "                                    <form action=\"";
            echo $this->env->getExtension('routing')->getPath("sonata_admin_search");
            echo "\" method=\"GET\" class=\"sidebar-form\" role=\"search\">
                                        <div class=\"input-group custom-search-form\">
                                            <input type=\"text\" name=\"q\" value=\"";
            // line 205
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "q"), "method"), "html", null, true);
            echo "\" class=\"form-control\" placeholder=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("search_placeholder", array(), "SonataAdminBundle"), "html", null, true);
            echo "\">
                                                <span class=\"input-group-btn\">
                                                    <button class=\"btn btn-flat\" type=\"submit\">
                                                        <i class=\"fa fa-search\"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </form>
                                ";
        }
        // line 214
        echo "                            ";
    }

    // line 216
    public function block_side_bar_before_nav($context, array $blocks = array())
    {
        echo " ";
    }

    // line 217
    public function block_side_bar_nav($context, array $blocks = array())
    {
        // line 218
        echo "                                ";
        if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "security", array()), "token", array()) && $this->env->getExtension('security')->isGranted("ROLE_SONATA_ADMIN"))) {
            // line 219
            echo "                                    ";
            echo $this->env->getExtension('knp_menu')->render($this->env->getExtension('sonata_admin')->getKnpMenu($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array())), array("template" => $this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getTemplate", array(0 => "knp_menu_template"), "method")));
            echo "
                                ";
        }
        // line 221
        echo "                            ";
    }

    // line 222
    public function block_side_bar_after_nav($context, array $blocks = array())
    {
        // line 223
        echo "                                <p class=\"text-center small\" style=\"border-top: 1px solid #444444; padding-top: 10px\"><a href=\"https://sonata-project.org\" rel=\"noreferrer\" target=\"_blank\">sonata project</a></p>
                            ";
    }

    // line 231
    public function block_sonata_page_content($context, array $blocks = array())
    {
        // line 232
        echo "                    <section class=\"content-header\">

                        ";
        // line 234
        $this->displayBlock('sonata_page_content_header', $context, $blocks);
        // line 282
        echo "                    </section>

                    <section class=\"content\">
                        ";
        // line 285
        $this->displayBlock('sonata_admin_content', $context, $blocks);
        // line 320
        echo "                    </section>
                ";
    }

    // line 234
    public function block_sonata_page_content_header($context, array $blocks = array())
    {
        // line 235
        echo "                            ";
        $this->displayBlock('sonata_page_content_nav', $context, $blocks);
        // line 281
        echo "                        ";
    }

    // line 235
    public function block_sonata_page_content_nav($context, array $blocks = array())
    {
        // line 236
        echo "                                ";
        if ((( !twig_test_empty((isset($context["_tab_menu"]) ? $context["_tab_menu"] : null)) ||  !twig_test_empty((isset($context["_actions"]) ? $context["_actions"] : null))) ||  !twig_test_empty((isset($context["_list_filters_actions"]) ? $context["_list_filters_actions"] : null)))) {
            // line 237
            echo "                                    <nav class=\"navbar navbar-default\" role=\"navigation\">
                                        <div class=\"container-fluid\">
                                            ";
            // line 239
            $this->displayBlock('tab_menu_navbar_header', $context, $blocks);
            // line 246
            echo "
                                            <div class=\"navbar-collapse\">
                                                <div class=\"navbar-left\">
                                                    ";
            // line 249
            if ( !twig_test_empty((isset($context["_tab_menu"]) ? $context["_tab_menu"] : null))) {
                // line 250
                echo "                                                        ";
                echo (isset($context["_tab_menu"]) ? $context["_tab_menu"] : null);
                echo "
                                                    ";
            }
            // line 252
            echo "                                                </div>

                                                ";
            // line 254
            if ((((array_key_exists("admin", $context) && array_key_exists("action", $context)) && ((isset($context["action"]) ? $context["action"] : null) == "list")) && (twig_length_filter($this->env, $this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "listModes", array())) > 1))) {
                // line 255
                echo "                                                    <div class=\"nav navbar-right btn-group\">
                                                        ";
                // line 256
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "listModes", array()));
                foreach ($context['_seq'] as $context["mode"] => $context["settings"]) {
                    // line 257
                    echo "                                                            <a href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "generateUrl", array(0 => "list", 1 => twig_array_merge($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "query", array()), "all", array()), array("_list_mode" => $context["mode"]))), "method"), "html", null, true);
                    echo "\" class=\"btn btn-default navbar-btn btn-sm";
                    if (($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "getListMode", array(), "method") == $context["mode"])) {
                        echo " active";
                    }
                    echo "\"><i class=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["settings"], "class", array()), "html", null, true);
                    echo "\"></i></a>
                                                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['mode'], $context['settings'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 259
                echo "                                                    </div>
                                                ";
            }
            // line 261
            echo "
                                                ";
            // line 262
            if ( !twig_test_empty(trim(strtr((isset($context["_actions"]) ? $context["_actions"] : null), array("<li>" => "", "</li>" => ""))))) {
                // line 263
                echo "                                                    <ul class=\"nav navbar-nav navbar-right\">
                                                        <li class=\"dropdown sonata-actions\">
                                                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
                // line 265
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("link_actions", array(), "SonataAdminBundle"), "html", null, true);
                echo " <b class=\"caret\"></b></a>
                                                            <ul class=\"dropdown-menu\" role=\"menu\">
                                                                ";
                // line 267
                echo (isset($context["_actions"]) ? $context["_actions"] : null);
                echo "
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                ";
            }
            // line 272
            echo "
                                                ";
            // line 273
            if ( !twig_test_empty((isset($context["_list_filters_actions"]) ? $context["_list_filters_actions"] : null))) {
                // line 274
                echo "                                                    ";
                echo (isset($context["_list_filters_actions"]) ? $context["_list_filters_actions"] : null);
                echo "
                                                ";
            }
            // line 276
            echo "                                            </div>
                                        </div>
                                    </nav>
                                ";
        }
        // line 280
        echo "                            ";
    }

    // line 239
    public function block_tab_menu_navbar_header($context, array $blocks = array())
    {
        // line 240
        echo "                                                ";
        if ( !twig_test_empty((isset($context["_navbar_title"]) ? $context["_navbar_title"] : null))) {
            // line 241
            echo "                                                    <div class=\"navbar-header\">
                                                        <a class=\"navbar-brand\" href=\"#\">";
            // line 242
            echo (isset($context["_navbar_title"]) ? $context["_navbar_title"] : null);
            echo "</a>
                                                    </div>
                                                ";
        }
        // line 245
        echo "                                            ";
    }

    // line 285
    public function block_sonata_admin_content($context, array $blocks = array())
    {
        // line 286
        echo "
                            ";
        // line 287
        $this->displayBlock('notice', $context, $blocks);
        // line 290
        echo "
                            ";
        // line 291
        if ( !twig_test_empty((isset($context["_preview"]) ? $context["_preview"] : null))) {
            // line 292
            echo "                                <div class=\"sonata-ba-preview\">";
            echo (isset($context["_preview"]) ? $context["_preview"] : null);
            echo "</div>
                            ";
        }
        // line 294
        echo "
                            ";
        // line 295
        if ( !twig_test_empty((isset($context["_content"]) ? $context["_content"] : null))) {
            // line 296
            echo "                                <div class=\"sonata-ba-content\">";
            echo (isset($context["_content"]) ? $context["_content"] : null);
            echo "</div>
                            ";
        }
        // line 298
        echo "
                            ";
        // line 299
        if ( !twig_test_empty((isset($context["_show"]) ? $context["_show"] : null))) {
            // line 300
            echo "                                <div class=\"sonata-ba-show\">";
            echo (isset($context["_show"]) ? $context["_show"] : null);
            echo "</div>
                            ";
        }
        // line 302
        echo "
                            ";
        // line 303
        if ( !twig_test_empty((isset($context["_form"]) ? $context["_form"] : null))) {
            // line 304
            echo "                                <div class=\"sonata-ba-form\">";
            echo (isset($context["_form"]) ? $context["_form"] : null);
            echo "</div>
                            ";
        }
        // line 306
        echo "
                            ";
        // line 307
        if (( !twig_test_empty((isset($context["_list_table"]) ? $context["_list_table"] : null)) ||  !twig_test_empty((isset($context["_list_filters"]) ? $context["_list_filters"] : null)))) {
            // line 308
            echo "                                ";
            if (trim((isset($context["_list_filters"]) ? $context["_list_filters"] : null))) {
                // line 309
                echo "                                    <div class=\"row\">
                                        ";
                // line 310
                echo (isset($context["_list_filters"]) ? $context["_list_filters"] : null);
                echo "
                                    </div>
                                ";
            }
            // line 313
            echo "
                                <div class=\"row\">
                                    ";
            // line 315
            echo (isset($context["_list_table"]) ? $context["_list_table"] : null);
            echo "
                                </div>

                            ";
        }
        // line 319
        echo "                        ";
    }

    // line 287
    public function block_notice($context, array $blocks = array())
    {
        // line 288
        echo "                                ";
        $this->loadTemplate("SonataCoreBundle:FlashMessage:render.html.twig", "SonataAdminBundle::standard_layout.html.twig", 288)->display($context);
        // line 289
        echo "                            ";
    }

    // line 327
    public function block_bootlint($context, array $blocks = array())
    {
        // line 328
        echo "            ";
        // line 329
        echo "            <script type=\"text/javascript\">
                javascript:(function(){var s=document.createElement(\"script\");s.onload=function(){bootlint.showLintReportForCurrentDocument([], {hasProblems: false, problemFree: false});};s.src=\"https://maxcdn.bootstrapcdn.com/bootlint/latest/bootlint.min.js\";document.body.appendChild(s)})();
            </script>
        ";
    }

    public function getTemplateName()
    {
        return "SonataAdminBundle::standard_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  978 => 329,  976 => 328,  973 => 327,  969 => 289,  966 => 288,  963 => 287,  959 => 319,  952 => 315,  948 => 313,  942 => 310,  939 => 309,  936 => 308,  934 => 307,  931 => 306,  925 => 304,  923 => 303,  920 => 302,  914 => 300,  912 => 299,  909 => 298,  903 => 296,  901 => 295,  898 => 294,  892 => 292,  890 => 291,  887 => 290,  885 => 287,  882 => 286,  879 => 285,  875 => 245,  869 => 242,  866 => 241,  863 => 240,  860 => 239,  856 => 280,  850 => 276,  844 => 274,  842 => 273,  839 => 272,  831 => 267,  826 => 265,  822 => 263,  820 => 262,  817 => 261,  813 => 259,  798 => 257,  794 => 256,  791 => 255,  789 => 254,  785 => 252,  779 => 250,  777 => 249,  772 => 246,  770 => 239,  766 => 237,  763 => 236,  760 => 235,  756 => 281,  753 => 235,  750 => 234,  745 => 320,  743 => 285,  738 => 282,  736 => 234,  732 => 232,  729 => 231,  724 => 223,  721 => 222,  717 => 221,  711 => 219,  708 => 218,  705 => 217,  699 => 216,  695 => 214,  681 => 205,  675 => 203,  672 => 202,  669 => 201,  665 => 225,  662 => 222,  659 => 217,  657 => 216,  654 => 215,  651 => 201,  648 => 200,  642 => 226,  640 => 200,  636 => 198,  633 => 197,  628 => 322,  626 => 231,  622 => 229,  619 => 197,  616 => 196,  608 => 185,  606 => 184,  598 => 178,  596 => 177,  588 => 171,  585 => 170,  580 => 166,  576 => 164,  570 => 162,  567 => 161,  564 => 160,  550 => 159,  544 => 157,  540 => 155,  534 => 153,  526 => 151,  524 => 150,  521 => 149,  518 => 148,  500 => 147,  497 => 146,  495 => 145,  492 => 144,  490 => 143,  487 => 142,  484 => 141,  480 => 192,  476 => 190,  474 => 170,  470 => 168,  468 => 141,  460 => 135,  457 => 134,  454 => 133,  450 => 132,  447 => 131,  443 => 129,  437 => 127,  434 => 126,  426 => 124,  424 => 123,  419 => 122,  416 => 121,  413 => 120,  410 => 119,  402 => 115,  398 => 113,  395 => 112,  390 => 193,  387 => 133,  384 => 119,  382 => 112,  379 => 111,  376 => 110,  370 => 106,  366 => 103,  363 => 102,  360 => 101,  346 => 100,  341 => 98,  338 => 97,  334 => 95,  331 => 94,  328 => 93,  311 => 92,  308 => 91,  305 => 90,  299 => 88,  297 => 87,  291 => 85,  288 => 84,  284 => 81,  281 => 80,  275 => 78,  272 => 77,  269 => 75,  264 => 74,  261 => 73,  258 => 71,  252 => 69,  249 => 68,  247 => 67,  245 => 66,  242 => 65,  239 => 64,  230 => 62,  225 => 61,  223 => 60,  209 => 49,  205 => 47,  199 => 46,  191 => 45,  183 => 44,  179 => 42,  176 => 41,  172 => 39,  169 => 38,  160 => 36,  155 => 35,  152 => 34,  149 => 33,  142 => 28,  139 => 27,  133 => 25,  126 => 334,  123 => 333,  120 => 327,  118 => 326,  114 => 324,  112 => 196,  109 => 195,  107 => 110,  100 => 106,  96 => 104,  94 => 84,  90 => 82,  88 => 41,  85 => 40,  83 => 33,  80 => 32,  78 => 27,  73 => 25,  69 => 23,  67 => 22,  65 => 21,  63 => 20,  61 => 19,  59 => 18,  57 => 17,  55 => 16,  53 => 15,  51 => 14,  49 => 13,  47 => 12,  45 => 11,);
    }
}
