<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH.'/lib/pear/HTML/QuickForm.php';
require_once MAX_PATH.'/lib/OA/Admin/UI/component/ArrayRenderer.php';
require_once MAX_PATH.'/lib/OA/Admin/UI/component/rule/RuleAdaptorRegistry.php';
require_once MAX_PATH.'/lib/OA/Admin/UI/component/decorator/DecoratorFactory.php';
require_once MAX_PATH.'/lib/OA/Admin/UI/component/rule/JQueryValidationRuleBuilder.php';


class OA_Admin_UI_Component_Form
    extends HTML_QuickForm
{
    private $dispatcher;
    private $id;
    private $forceClientValidation;
    private $jQueryValidationBuilder;
    private $hasRequiredFields;

    function __construct($formName='', $method='POST', $action='', $target='', $attributes=null, $trackSubmit = true)
    {
        parent::__construct($formName, $method, $action, $target, $attributes, $trackSubmit);
        $this->id = $formName;
        $this->forceClientValidation = false;
        $this->hasRequiredFields = false;

        //register custom fields
        parent::registerElementType('html',
            MAX_PATH.'/lib/OA/Admin/UI/component/Html.php',
            'OA_Admin_UI_Component_Html');

        parent::registerElementType('controls',
            MAX_PATH.'/lib/OA/Admin/UI/component/FormControls.php',
            'OA_Admin_UI_Component_FormControls');

        parent::registerElementType('break',
            MAX_PATH.'/lib/OA/Admin/UI/component/FormBreak.php',
            'OA_Admin_UI_Component_FormBreak');

        parent::registerElementType('custom',
            MAX_PATH.'/lib/OA/Admin/UI/component/CustomFormElement.php',
            'OA_Admin_UI_Component_CustomFormElement');

        parent::registerElementType('plugin-custom',
            MAX_PATH.'/lib/OA/Admin/UI/component/CustomPluginFormElement.php',
            'OA_Admin_UI_Component_CustomPluginFormElement');

        parent::registerElementType('script',
            MAX_PATH.'/lib/OA/Admin/UI/component/ScriptFormElement.php',
            'OA_Admin_UI_Component_ScriptFormElement');

        parent::registerElementType('plugin-script',
            MAX_PATH.'/lib/OA/Admin/UI/component/PluginScriptFormElement.php',
            'OA_Admin_UI_Component_PluginScriptFormElement');

        //register additional rules
        $this->registerRule('wholenumber', 'regex', '/^\d+$/');
        $this->registerRule('wholenumber-', 'regex', '/^\d+$|^\-$/');
        $this->registerRule('formattednumber', 'regex', '/^\d+$|^\d(,\d{3})+$/');
        $this->registerRule('decimal', 'regex', '/^([+-])?\d+(\.\d+)?$/');
        $this->registerRule('decimalplaces', 'rule', 'OA_Admin_UI_Rule_DecimalPlaces',
            MAX_PATH.'/lib/OA/Admin/UI/component/rule/DecimalPlaces.php');
        $this->registerRule('min', 'rule', 'OA_Admin_UI_Rule_Min',
            MAX_PATH.'/lib/OA/Admin/UI/component/rule/Min.php');
        $this->registerRule('max', 'rule', 'OA_Admin_UI_Rule_Max',
            MAX_PATH.'/lib/OA/Admin/UI/component/rule/Max.php');

        $this->registerRule('unique', 'rule', 'OA_Admin_UI_Rule_Unique',
            MAX_PATH.'/lib/OA/Admin/UI/component/rule/Unique.php');

        $this->registerRule('equal', 'rule', 'OA_Admin_UI_Rule_Equal',
            MAX_PATH.'/lib/OA/Admin/UI/component/rule/Equal.php');

        //register jquery rule adaptors
        $this->registerJQueryRuleAdaptor('required', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormRequiredRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryRequiredRule');

        $this->registerJQueryRuleAdaptor('minlength', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormMinLengthRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryMinLengthRule');
        $this->registerJQueryRuleAdaptor('maxlength', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormMaxLengthRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryMaxLengthRule');

        $this->registerJQueryRuleAdaptor('email', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormEmailRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryEmailRule');

        $this->registerJQueryRuleAdaptor('numeric', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormDigitsRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryDigitsRule');
        $this->registerJQueryRuleAdaptor('nonzero', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormNonZeroRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryNonZeroRule');
        $this->registerJQueryRuleAdaptor('decimal', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormNumberRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryNumberRule');
        $this->registerJQueryRuleAdaptor('min', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormMinRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryMinRule');
        $this->registerJQueryRuleAdaptor('max', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormMaxRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryMaxRule');
        $this->registerJQueryRuleAdaptor('decimalplaces', MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormDecimalPlacesAdaptor.php',
            'OA_Admin_UI_Rule_QuickFormDecimalPlacesAdaptor');


        $this->registerJQueryRuleAdaptor("unique", MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormUniqueRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryUniqueRule');

        $this->registerJQueryRuleAdaptor("equal", MAX_PATH.'/lib/OA/Admin/UI/component/rule/QuickFormEqualRuleAdaptor.php',
            'OA_Admin_UI_Rule_JQueryEqualRule');

        //register element decorators
        $this->registerElementDecorator('tag', MAX_PATH.'/lib/OA/Admin/UI/component/decorator/HTMLTagDecorator.php',
            'OA_Admin_UI_HTMLTagDecorator');
        $this->registerElementDecorator('process', MAX_PATH.'/lib/OA/Admin/UI/component/decorator/ProcessingDecorator.php',
            'OA_Admin_UI_ProcessingDecorator');


        //apply flat class
        $this->setAttribute("class", "flat");

        //trim spaces from all data sent by the user
        $this->applyFilter('__ALL__', 'trim');

        $this->addElement('hidden', 'token', phpAds_SessionGetToken());
        $this->addRule('token', 'Invalid request token', 'callback', 'phpAds_SessionValidateToken');
    }

    function validate()
    {
        $ret = parent::validate();

        if (!$ret) {
            // The form returned an error. We need to generate a new CSRF token, in any.
            $token = $this->getElement('token');
            if (!empty($token)) {
                $token->setValue(phpAds_SessionGetToken());
            }
        }

        return $ret;
    }

    /**
     * Registers new JQuery QuickForm rule adaptor. Registered adaptors should
     * implement OA_Admin_UI_Rule_QuickFormToJQueryRuleAdaptor
     *
     * @param     string    $quickFormRuleName   Name of adapted QuickForm rule
     * @param     string    $include    Include path for adaptor
     * @param     string    $className  Adaptor class name
     * @return unknown
     */
    public function registerJQueryRuleAdaptor($quickFormRuleName, $include, $className)
    {
        $registry = OA_Admin_UI_Rule_JQueryRuleAdaptorRegistry::singleton();
        return $registry->registerJQueryRuleAdaptor($quickFormRuleName, $include, $className);
    }


    /**
     * Registers new element decorator. Registered decorators should implement
     * implement OA_Admin_UI_Decorator interface.
     *
     * @param     string    $decoratorName   Name of decorator
     * @param     string    $include    Include path for decorator
     * @param     string    $className  Decorator class name
     * @return unknown
     */
    public function registerElementDecorator($decoratorName, $include, $className)
    {
        $registry = OA_Admin_UI_Decorator_Factory::singleton();
        return $registry->registerDecorator($decoratorName, $include, $className);
    }


    /**
     * Allows to turn on client validation by default for validation rules that
     * does not explicitly specify "client" validation type.
     *
     * Validation rules that explicitly define "server" side validation will not
     * be enforced to run client side.
     *
     * Note: If you enforce client validation it will be applied
     * to all rules that were added after the it was enforced. It does not affect
     * rules added before it was invoked.
     * If you want all form rules to be applied first force client validation
     * and then start adding rules.
     *
     */
    public function forceClientValidation($force)
    {
        $this->forceClientValidation = $force;
    }


    /**
     * Overrides parent addRule method. Adds validation rule for an element.
     * Takes in the account current state of forceClientValidation setting
     * modifyig $validation parameter value if required
     *
     * @param    string     $element       Form element name
     * @param    string     $message       Message to display for invalid data
     * @param    string     $type          Rule type, use getRegisteredRules() to get types
     * @param    string     $format        (optional)Required for extra rule data
     * @param    string     $validation    (optional)Where to perform validation: "server", "client". Defaults to "server", unless forceClientValidation is not set on form
     * @param    boolean    $reset         Client-side validation: reset the form element to its original value if there is an error?
     * @param    boolean    $force         Force the rule to be applied, even if the target form element does not exist
     * @access   public
     * @throws   HTML_QuickForm_Error
     *
     */
    function addRule($element, $message, $type, $format=null, $validation=null, $reset = false, $force = false)
    {
        if (empty($validation) && $this->forceClientValidation) {
            $validation = 'client';
        }
        if ($type == 'required') {
            $this->hasRequiredFields = true;
        }
        return parent::addRule($element, $message, $type, $format, $validation, $reset, $force);
    }

    function addGroupRule($group, $arg1, $type='', $format=null, $howmany=0, $validation = 'server', $reset = false)
    {
        if (empty($validation) && $this->forceClientValidation) {
            $validation = 'client';
        }

        if (is_array($arg1)) {
            foreach($arg1 as $elementIndex => $rules) {
                foreach ($rules as $rule) {
                    if($rule[1] == 'required') {
                        $this->hasRequiredFields = true;
                    }
                }
            }
        }

        if ($type == 'required') {
            $this->hasRequiredFields = true;
        }
        return parent::addGroupRule($group, $arg1, $type, $format, $howmany, $validation, $reset);
    }

    public function addElements($elements = array())
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
    }


    /**
     * Overrides method from parent, append name defaults to false
     * @param    array      $elements       array of elements composing the group
     * @param    string     $name           (optional)group name
     * @param    string     $groupLabel     (optional)group label
     * @param    string     $separator      (optional)string to separate elements
     * @param    string     $appendName     (optional)specify whether the group name should be
     *                                      used in the form element name ex: group[element], defaults to false
     * @return   HTML_QuickForm_group       reference to a newly added group
     * @since    2.8
     * @access   public
     * @throws   HTML_QuickForm_Error
     */
    function &addGroup($elements, $name=null, $groupLabel='', $separator=null, $appendName = false)
    {
        return parent::addGroup($elements, $name, $groupLabel, $separator, $appendName);
    }


    public function addDecorator($elementName, $decoratorName, $decoratorOptions = null)
    {
        $elementDecorators = $this->decorators[$elementName];

        if (empty($elementDecorators)) {
            $elementDecorators = array();
        }
        $elementDecorators[] = OA_Admin_UI_Decorator_Factory::newDecorator($decoratorName, $decoratorOptions);

        $this->decorators[$elementName] = $elementDecorators;
    }


    public function getDecorators($elementName)
    {
        return $this->decorators[$elementName];
    }


    function toArray($collectHidden = false)
    {
        $renderer = new OA_Admin_UI_Component_ArrayRenderer($collectHidden);
        $this->accept($renderer);
        return $renderer->toArray();
     }


    public function serialize()
    {
        $result =  $this->toArray(true);

        return $result;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getJQueryValidationMethods()
    {
        if (empty($this->_rules) || empty($this->_attributes['onsubmit'])) {
            return '';
        }

        $activeRules = $this->getActiveRules();
        $builder = $this->getJQueryValidationBuilder();

        return $builder->getJQueryValidationMethodsScript($activeRules);
    }


    /**
     * Return a JS rule definition applicable for JQuery validation plugin
     * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
     * based on active client rules.
     * Please not that this does not take into account some properties of the
     * rule like. eg. 'reset'.
     *
     */
    public function getJQueryValidationRules()
    {
        if (empty($this->_rules) || empty($this->_attributes['onsubmit'])) {
            return '';
        }
        $activeRules = $this->getActiveRules();
        $builder = $this->getJQueryValidationBuilder();

        return $builder->getJQueryValidationRulesScript($activeRules);
    }


    /**
     * Gets the builder for the jquery validation script
     *
     * @return OA_Admin_UI_Rule_JQueryValidationRuleBuilder
     */
    private function getJQueryValidationBuilder()
    {
        if ($this->jQueryValidationBuilder == null) {
            $jQueryValidationBuilder = new OA_Admin_UI_Rule_JQueryValidationRuleBuilder();
        }
        return $jQueryValidationBuilder;
    }


    /**
     * Return active validation rules
     *
     * @return unknown
     */
    private function getActiveRules()
    {
        $js_escape = array(
            "\r"    => '\r',
            "\n"    => '\n',
            "\t"    => '\t',
            "'"     => "\\'",
            '"'     => '\"',
            '\\'    => '\\\\'
        );

        $activeRules = array();
        $jqueryMessages = array();

        foreach ($this->_rules as $elementName => $rules) {
            $activeRules[$elementName] = array();
            $jqueryMessages[$elementName] = array();
            foreach ($rules as $rule) {
                if ('client' == $rule['validation'] || $this->forceClientValidation) {
                    unset($element);

                    $dependent  = isset($rule['dependent']) && is_array($rule['dependent']);
                    $rule['message'] = strtr($rule['message'], $js_escape);

                    if (isset($rule['group'])) {
                        $group    =& $this->getElement($rule['group']);
                        // No JavaScript validation for frozen elements
                        if ($group->isFrozen()) {
                            continue 2;
                        }
                        $elements =& $group->getElements();
                        foreach (array_keys($elements) as $key) {
                            if ($elementName == $group->getElementName($key)) {
                                $element =& $elements[$key];
                                break;
                            }
                        }
                    } elseif ($dependent) {
                        $element   =  array();
                        $element[] =& $this->getElement($elementName);
                        foreach ($rule['dependent'] as $elName) {
                            $element[] =& $this->getElement($elName);
                        }
                    } else {
                        $element =& $this->getElement($elementName);
                    }
                    // No JavaScript validation for frozen elements
                    if (is_object($element) && $element->isFrozen()) {
                        continue 2;
                    } elseif (is_array($element)) {
                        foreach (array_keys($element) as $key) {
                            if ($element[$key]->isFrozen()) {
                                continue 3;
                            }
                        }
                    }

                    $activeRules[$elementName][] = $rule;
                }
            }
        }

        return $activeRules;
    }


    function hasRequiredFields()
    {
        return $this->hasRequiredFields;
    }
}

?>
