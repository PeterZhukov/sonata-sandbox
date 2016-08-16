<?php

/* SonataFormatterBundle:Form:formatter.html.twig */
class __TwigTemplate_345a327076195dbac2f2e40bf3262507254706aff9bd957b443674c4a06a4d4f extends Sonata\CacheBundle\Twig\TwigTemplate14
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'sonata_formatter_type_widget' => array($this, 'block_sonata_formatter_type_widget'),
            'sonata_simple_formatter_type_widget' => array($this, 'block_sonata_simple_formatter_type_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('sonata_formatter_type_widget', $context, $blocks);
        // line 72
        echo "
";
        // line 73
        $this->displayBlock('sonata_simple_formatter_type_widget', $context, $blocks);
    }

    // line 1
    public function block_sonata_formatter_type_widget($context, array $blocks = array())
    {
        // line 2
        echo "
    <!-- widget: sonata_formatter_type_widget -->
    <div style=\"margin-bottom: 5px;\">
        ";
        // line 5
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["format_field"]) ? $context["format_field"] : null), array(), "array"), 'widget');
        echo "
        ";
        // line 6
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["format_field_options"]) ? $context["format_field_options"] : null), "choices", array())) > 1)) {
            // line 7
            echo "            <i>";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("please_select_format_method", array(), "SonataFormatterBundle"), "html", null, true);
            echo "</i>
        ";
        }
        // line 9
        echo "    </div>

    ";
        // line 11
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["source_field"]) ? $context["source_field"] : null), array(), "array"), 'widget');
        echo "

    <script>
        var ";
        // line 14
        echo twig_escape_filter($this->env, (isset($context["source_id"]) ? $context["source_id"] : null), "html", null, true);
        echo "_rich_instance = false;

        jQuery(document).ready(function() {

            // This code requires CKEDITOR and jQuery MarkItUp
            if (typeof CKEDITOR === 'undefined' || jQuery().markItUp == undefined) {
                return;
            }

            jQuery('#";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["format_field"]) ? $context["format_field"] : null), array(), "array"), "vars", array()), "id", array()), "html", null, true);
        echo "').parents(\"form\").on('click', function(event) {
                if (";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["source_id"]) ? $context["source_id"] : null), "html", null, true);
        echo "_rich_instance) {
                    ";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["source_id"]) ? $context["source_id"] : null), "html", null, true);
        echo "_rich_instance.updateElement();
                }
            });

            jQuery('#";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["format_field"]) ? $context["format_field"] : null), array(), "array"), "vars", array()), "id", array()), "html", null, true);
        echo "').change(function(event) {
                var elms = jQuery('#";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["source_field"]) ? $context["source_field"] : null), array(), "array"), "vars", array()), "id", array()), "html", null, true);
        echo "');
                elms.markItUpRemove();
                if (";
        // line 32
        echo twig_escape_filter($this->env, (isset($context["source_id"]) ? $context["source_id"] : null), "html", null, true);
        echo "_rich_instance) {
                    ";
        // line 33
        echo twig_escape_filter($this->env, (isset($context["source_id"]) ? $context["source_id"] : null), "html", null, true);
        echo "_rich_instance.destroy();
                }

                var val = jQuery(this).val();
                var appendClass = val;
                switch(val) {
                    case 'textile':
                        elms.markItUp(markitup_sonataTextileSettings);
                        break;
                    case 'markdown':
                        elms.markItUp(markitup_sonataMarkdownSettings);
                        break;
                    case 'bbcode':
                        elms.markItUp(markitup_sonataBBCodeSettings);
                        break;
                    case 'rawhtml':
                        elms.markItUp(markitup_sonataHtmlSettings);
                        appendClass = 'html';
                        break;
                    case 'richhtml':
                        ";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["source_id"]) ? $context["source_id"] : null), "html", null, true);
        echo "_rich_instance = ";
        echo $this->env->getExtension('ivory_ckeditor')->renderReplace($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["source_field"]) ? $context["source_field"] : null), array(), "array"), "vars", array()), "id", array()), (isset($context["ckeditor_configuration"]) ? $context["ckeditor_configuration"] : null));
        echo ";

                }

                var parent = elms.parents('div.markItUp');

                if (parent) {
                    for (name in ['textile', 'markdown', 'bbcode', 'rawhtml', 'richhtml', 'rawhtml']) {
                        parent.removeClass(name)
                    }

                    parent.addClass(appendClass);
                }
            });

            jQuery('#";
        // line 68
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()), (isset($context["format_field"]) ? $context["format_field"] : null), array(), "array"), "vars", array()), "id", array()), "html", null, true);
        echo "').trigger('change');
        });
    </script>
";
    }

    // line 73
    public function block_sonata_simple_formatter_type_widget($context, array $blocks = array())
    {
        // line 74
        echo "
    <!-- widget: sonata_simple_formatter_type_widget -->

    ";
        // line 77
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : null), 'widget');
        echo "

    <script>
        jQuery(document).ready(function() {
            // This code requires CKEDITOR and jQuery MarkItUp
            if (typeof CKEDITOR === 'undefined' || jQuery().markItUp == undefined) {
                return;
            }

            var elms = jQuery('#";
        // line 86
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "vars", array()), "id", array()), "html", null, true);
        echo "');

            ";
        // line 88
        if (((isset($context["format"]) ? $context["format"] : null) == "textile")) {
            // line 89
            echo "                elms.markItUp(markitup_sonataTextileSettings);
            ";
        } elseif ((        // line 90
(isset($context["format"]) ? $context["format"] : null) == "markdown")) {
            // line 91
            echo "                elms.markItUp(markitup_sonataMarkdownSettings);
            ";
        } elseif ((        // line 92
(isset($context["format"]) ? $context["format"] : null) == "bbcode")) {
            // line 93
            echo "                elms.markItUp(markitup_sonataBBCodeSettings);
            ";
        } elseif ((        // line 94
(isset($context["format"]) ? $context["format"] : null) == "rawhtml")) {
            // line 95
            echo "                elms.markItUp(markitup_sonataHtmlSettings);
            ";
        } elseif ((        // line 96
(isset($context["format"]) ? $context["format"] : null) == "richhtml")) {
            // line 97
            echo "                ";
            echo $this->env->getExtension('ivory_ckeditor')->renderReplace($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "vars", array()), "id", array()), (isset($context["ckeditor_configuration"]) ? $context["ckeditor_configuration"] : null));
            echo ";
            ";
        }
        // line 99
        echo "
            var parent = elms.parents('div.markItUp');

            if (parent) {
                parent.addClass('";
        // line 103
        echo twig_escape_filter($this->env, (isset($context["format"]) ? $context["format"] : null), "html", null, true);
        echo "');
            }

        });
    </script>
";
    }

    public function getTemplateName()
    {
        return "SonataFormatterBundle:Form:formatter.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  210 => 103,  204 => 99,  198 => 97,  196 => 96,  193 => 95,  191 => 94,  188 => 93,  186 => 92,  183 => 91,  181 => 90,  178 => 89,  176 => 88,  171 => 86,  159 => 77,  154 => 74,  151 => 73,  143 => 68,  123 => 53,  100 => 33,  96 => 32,  91 => 30,  87 => 29,  80 => 25,  76 => 24,  72 => 23,  60 => 14,  54 => 11,  50 => 9,  44 => 7,  42 => 6,  38 => 5,  33 => 2,  30 => 1,  26 => 73,  23 => 72,  21 => 1,);
    }
}
