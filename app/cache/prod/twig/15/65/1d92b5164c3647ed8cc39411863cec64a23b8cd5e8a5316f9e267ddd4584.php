<?php

/* SonataOrderBundle:Block:recent_orders.html.twig */
class __TwigTemplate_15651d92b5164c3647ed8cc39411863cec64a23b8cd5e8a5316f9e267ddd4584 extends Sonata\CacheBundle\Twig\TwigTemplate14
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
        return $this->loadTemplate($this->getAttribute($this->getAttribute((isset($context["sonata_block"]) ? $context["sonata_block"] : null), "templates", array()), "block_base", array()), "SonataOrderBundle:Block:recent_orders.html.twig", 11);
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
    <div class=\"box box-primary\">
        ";
        // line 16
        if ($this->getAttribute((isset($context["settings"]) ? $context["settings"] : null), "title", array())) {
            // line 17
            echo "            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">
                    <i class=\"fa fa-barcode\"></i> ";
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
            ";
        // line 27
        if ((twig_length_filter($this->env, (isset($context["orders"]) ? $context["orders"] : null)) > 0)) {
            // line 28
            echo "                <table class=\"sonata-order-block-order-container table table-condensed\">
                    ";
            // line 29
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["orders"]) ? $context["orders"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["order"]) {
                // line 30
                echo "                        <tr>
                            ";
                // line 31
                if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
                    // line 32
                    echo "                                <td><a href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.order.admin.order"), "method"), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($context["order"], "id", array()))), "method"), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["order"], "reference", array()), "html", null, true);
                    echo "</a></td>
                            ";
                } else {
                    // line 34
                    echo "                                <td><a href=\"";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("sonata_order_view", array("reference" => $this->getAttribute($context["order"], "reference", array()))), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["order"], "reference", array()), "html", null, true);
                    echo "</a></td>
                            ";
                }
                // line 36
                echo "                            <td class=\"number\">";
                echo $this->env->getExtension('sonata_intl_number')->formatCurrency($this->getAttribute($context["order"], "totalInc", array()), $this->getAttribute($this->getAttribute($context["order"], "currency", array()), "label", array()));
                echo "</td>
                            <td><span class=\"label";
                // line 37
                echo twig_escape_filter($this->env, (($this->env->getExtension('sonata_core_status')->statusClass($context["order"], null, "danger")) ? ((" label-" . $this->env->getExtension('sonata_core_status')->statusClass($context["order"], null, "danger"))) : ("")), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute($context["order"], "statusName", array()), array(), "SonataOrderBundle"), "html", null, true);
                echo "</span></td>
                            <td>";
                // line 38
                echo $this->env->getExtension('sonata_intl_datetime')->formatDatetime($this->getAttribute($context["order"], "createdAt", array()), null, $this->getAttribute($context["order"], "locale", array()));
                echo "</td>
                        </tr>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 41
            echo "                </table>
            ";
        } else {
            // line 43
            echo "                ";
            if (($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin")) {
                // line 44
                echo "                    <p>";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("no_order_found", array(), "SonataOrderBundle"), "html", null, true);
                echo "</p>
                ";
            } else {
                // line 46
                echo "                    <p>";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("sonata.order.list.no_orders", array(), "SonataOrderBundle"), "html", null, true);
                echo "</p>
                ";
            }
            // line 48
            echo "            ";
        }
        // line 49
        echo "        </div>

        ";
        // line 51
        if ((twig_length_filter($this->env, (isset($context["orders"]) ? $context["orders"] : null)) > 0)) {
            // line 52
            echo "            <div class=\"box-footer\">
                ";
            // line 53
            if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
                // line 54
                echo "                    <a href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.order.admin.order"), "method"), "generateUrl", array(0 => "list"), "method"), "html", null, true);
                echo "\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-list\"></i>&nbsp;";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("view_all_orders", array(), "SonataOrderBundle"), "html", null, true);
                echo "</a>
                ";
            } else {
                // line 56
                echo "                    <a href=\"";
                echo $this->env->getExtension('routing')->getUrl("sonata_order_index");
                echo "\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-list\"></i>&nbsp;";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("view_all_orders", array(), "SonataOrderBundle"), "html", null, true);
                echo "</a>
                ";
            }
            // line 58
            echo "            </div>
        ";
        }
        // line 60
        echo "    </div>

";
    }

    public function getTemplateName()
    {
        return "SonataOrderBundle:Block:recent_orders.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 60,  155 => 58,  147 => 56,  139 => 54,  137 => 53,  134 => 52,  132 => 51,  128 => 49,  125 => 48,  119 => 46,  113 => 44,  110 => 43,  106 => 41,  97 => 38,  91 => 37,  86 => 36,  78 => 34,  70 => 32,  68 => 31,  65 => 30,  61 => 29,  58 => 28,  56 => 27,  53 => 26,  51 => 25,  47 => 23,  40 => 19,  36 => 17,  34 => 16,  30 => 14,  27 => 13,  18 => 11,);
    }
}
