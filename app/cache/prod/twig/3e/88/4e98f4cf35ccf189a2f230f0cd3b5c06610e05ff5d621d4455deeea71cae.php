<?php

/* SonataCustomerBundle:Block:recent_customers.html.twig */
class __TwigTemplate_3e884e98f4cf35ccf189a2f230f0cd3b5c06610e05ff5d621d4455deeea71cae extends Sonata\CacheBundle\Twig\TwigTemplate14
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
        return $this->loadTemplate($this->getAttribute($this->getAttribute((isset($context["sonata_block"]) ? $context["sonata_block"] : null), "templates", array()), "block_base", array()), "SonataCustomerBundle:Block:recent_customers.html.twig", 11);
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
                    <i class=\"fa fa-user\"></i> ";
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
        if ((twig_length_filter($this->env, (isset($context["customers"]) ? $context["customers"] : null)) > 0)) {
            // line 26
            echo "                <div class=\"sonata-customer-block-customer-container list-group\">
                    ";
            // line 27
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["customers"]) ? $context["customers"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["customer"]) {
                // line 28
                echo "                        <a class=\"list-group-item\"
                           href=\"
                            ";
                // line 30
                if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
                    // line 31
                    echo "                                ";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.customer.admin.customer"), "method"), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($context["customer"], "id", array()))), "method"), "html", null, true);
                    echo "
                            ";
                } else {
                    // line 33
                    echo "                                ";
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("sonata_customer_view", array("id" => $this->getAttribute($context["customer"], "id", array()))), "html", null, true);
                    echo "
                            ";
                }
                // line 35
                echo "                            \">
                            ";
                // line 36
                echo twig_escape_filter($this->env, $context["customer"], "html", null, true);
                echo " - ";
                echo $this->env->getExtension('sonata_intl_datetime')->formatDatetime($this->getAttribute($context["customer"], "createdAt", array()));
                echo "
                        </a>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['customer'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 39
            echo "                </div>
            ";
        } else {
            // line 41
            echo "                <p>";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("no_customer_found", array(), "SonataCustomerBundle"), "html", null, true);
            echo "</p>
            ";
        }
        // line 43
        echo "        </div>

        <div class=\"box-footer\">
            ";
        // line 46
        if ((($this->getAttribute((isset($context["context"]) ? $context["context"] : null), "getSetting", array(0 => "mode"), "method") == "admin") && array_key_exists("admin_pool", $context))) {
            // line 47
            echo "                <a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "getAdminByAdminCode", array(0 => "sonata.customer.admin.customer"), "method"), "generateUrl", array(0 => "list"), "method"), "html", null, true);
            echo "\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-list\"></i>&nbsp;";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("view_all_customers", array(), "SonataCustomerBundle"), "html", null, true);
            echo "</a>
            ";
        }
        // line 49
        echo "        </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "SonataCustomerBundle:Block:recent_customers.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 49,  109 => 47,  107 => 46,  102 => 43,  96 => 41,  92 => 39,  81 => 36,  78 => 35,  72 => 33,  66 => 31,  64 => 30,  60 => 28,  56 => 27,  53 => 26,  51 => 25,  47 => 23,  40 => 19,  36 => 17,  34 => 16,  30 => 14,  27 => 13,  18 => 11,);
    }
}
