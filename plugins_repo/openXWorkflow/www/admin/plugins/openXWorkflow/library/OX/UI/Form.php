<?php

/**
 * Manages menu entries for the applications. Work in progress, subject to large changes.
 */
class OX_UI_Form extends Zend_Form
{
    /**
     * Internal display group for form buttons
     *
     * @var Zend_Form_DisplayGroup
     */
    protected $buttonsDisplayGroup = null;
    
    /** Name of the internal display group for buttons */
    protected $buttonsDisplayGroupName = 'buttons';
    
    /** Names of elements inside the internal display group for buttons */
    protected $buttonsDisplayGroupElementNames = array ();
    
    /** Submit button label */
    protected $submitLabel = 'Save Changes';
    
    /** Submit button options */
    protected $submitOptions = null;
    
    /** Form validation error message. */
    protected $formValidationErrorMessage = 'To save changes, please correct the marked fields.';
    
    /** Form-level message independent of form validation messages */
    protected $formMessage = null;
    protected $formMessageType = 'info';
    
    /** Determines whether to show the 'Required fields' annotation */
    protected $requiredInfo = true;
    
    /**
     * Form identifier useful when there is more than one form on one screen. In that
     * case, this id will be prefixed to all other ids within the form.
     */
    protected $id = '';
    
    /**
     * @var array of OX_UI_Form_Listener
     */
    protected $listeners = array ();
    
    /**
     * @var array of OX_UI_Form_Validate_FormValidator
     */
    protected $formValidators = array ();
    
    /**
     * @var FragmentManagerListener
     */
    protected $fragmentManagerListener;


    public function __construct($options = null)
    {
        parent::__construct($options);
        OX_UI_Controller_Default::registerPlugin(new PageLocalMessageSetter($this));
    }


    /**
     * Installs custom element and decorator paths for this form.
     */
    public function init()
    {
        $this->addPrefixPath("OX_UI_Form_Element", "OX/UI/Form/Element", self::ELEMENT);
        $this->addPrefixPath("OX_UI_Form_Decorator", "OX/UI/Form/Decorator", self::DECORATOR);
        $this->setAttrib('class', 'main');
        
        $this->fragmentManagerListener = new FragmentManagerListener($this);
        $this->addListener($this->fragmentManagerListener);
    }


    /**
     * Removes some of Zend's default decorators that do not fit our layout.
     */
    public function loadDefaultDecorators()
    {
        parent::loadDefaultDecorators();
        $this->removeDecorator("HtmlTag");
    }


    /**
     *
     */
    public function setActionUrl($action, $controller = null, $module = null, $aParam = null)
    {
        $this->setAction(OX_UI_View_Helper_ActionUrl::actionUrl($action, $controller, $module, $aParam));
    }


    /**
     * Adds an element wrapped with a form line to this form. If a line with the provided
     * $lineName does not exist, a new line will be created. If a line with the provided
     * $lineName already exists, the element will be appended at the end of the existing
     * line, $lineOptions will override the line options used for previous calls with the
     * same $lineName.
     *
     * @param $element see Zend_Form::addElement()
     * @param $elementName see Zend_Form::addElement()
     * @param $lineName name for the line element
     * @param $elementOptions see Zend_Form::addElement()
     * @param $lineOptions options for the line element
     */
    public function addElementWithLine($element, $elementName = null, $lineName = null, 
            $elementOptions = null, 
            array $lineOptions = null)
    {
        self::addElement($element, $elementName, $elementOptions);
        
        // If lineName not specified, use some default
        if ($lineName == null) {
            $lineName = $elementName . "Line";
        }
        
        // Check if the line exists, if it does not -- create one
        $line = $this->getElement($lineName);
        if ($line == null) {
            $this->addFormLine(array (), $lineName, $lineOptions);
            $line = $this->getElement($lineName);
        }
        
        $this->addElementsToFormLine(array ($elementName), $line);
    }


    /**
     * Adds a form line to this form. This method is very similar to the addDisplayGroup()
     * method and can be used to create mutliple elements in one form line. Form lines
     * are elements themselves, so they can be put in display groups. We need to have
     * this method on the level of form because it needs to modify the internal data
     * structures of the form.
     *
     * @param array $elements names of elements to be added to the line. The elements must
     *         be added to the form before they are grouped into lines.
     * @param $name identifier for the form line. The identifier can be used when e.g.
     *         grouping form lines into display groups.
     */
    public function addFormLine(array $elements, $name, array $options = null)
    {
        $lineElement = $this->createElement("Line", $name, $options);
        $this->addElementsToFormLine($elements, $lineElement);
        $this->addElement($lineElement);
        
        return $this;
    }


    public function addFormFragment(OX_UI_Form_Fragment $fragment)
    {
        $this->fragmentManagerListener->addFragment($fragment);
    }
    
    
    /**
     * Adds elements to an existing line.
     */
    protected function addElementsToFormLine($elements, $lineElement)
    {
        $line = array ();
        foreach ($elements as $element) {
            if (isset($this->_elements[$element])) {
                $add = $this->getElement($element);
                if (null !== $add) {
                    unset($this->_order[$element]);
                    $line[] = $add;
                }
            }
        }
        
        if (!empty($line)) {
            $lineElement->addElements($line);
        }
    }


    /**
     * Adds a submit button to this form. This method is defined here so that we don't
     * bother form developers with placing submit buttons in their dedicated display
     * group. The display group for buttons can be retrieved with getSubmitAreaDisplayGroup().
     *
     * @param $label label for the button
     * @param $name name of the submit button
     * @param array $options options for the button. All regular options of a button
     *         are supported.
     */
    public function addSubmitButton($label = null, $name = 'submit', array $options = array())
    {
        if (!$label) {
            $label = $this->submitLabel;
        }
        
        // Add 'save' to the provided css class, if any
        $class = "save";
        if (!isset($options['class'])) {
            $options['class'] = $class;
        }
        else {
            $options['class'] = OX_UI_Form_Element_Utils::addClass($options['class'], $class);
        }
        $options['type'] = 'submit';
        
        OX_Common_ArrayUtils::addAll($options, $this->submitOptions);
        
        $this->addButton($label, $name, $options);
    }


    /**
     * Adds a secondary button to the submit area of this form. This method is defined here so that we don't
     * bother form developers with placing submit buttons in their dedicated display
     * group. The display group for buttons can be retrieved with getSubmitAreaDisplayGroup().
     *
     * @param $label label for the button
     * @param $name name of the submit button
     * @param array $options options for the button. All regular options of a button
     *         are supported.
     */
    public function addSecondaryButton($label = 'Type meaningful label', $name = 'secondary', array $options = array())
    {
        $this->addButton($label, $name, $options);
    }


    /**
     * Adds a button to the submit area of this form. This method is defined here so that we don't
     * bother form developers with placing submit buttons in their dedicated display
     * group. The display group for buttons can be retrieved with getSubmitAreaDisplayGroup().
     *
     * @param $label label for the button
     * @param $name name of the submit button
     * @param array $options options for the button. All regular options of a button
     *         are supported.
     */
    public function addButton($label = 'Type meaningful label', $name = 'button', array $options = array())
    {
        // Set default label
        if (!isset($options['label'])) {
            $options['label'] = $label;
        }
        
        $this->addElement('button', $name, $options);
        $this->buttonsDisplayGroupElementNames[] = $name;
        $this->createButtonsDisplayGroup($this->buttonsDisplayGroupElementNames);
    }


    /**
     * Adds an action url to the submit buttons area of the form. This method is defined
     * here so that we don't bother form developers with placing submit buttons in their
     * dedicated display group. The display group for buttons can be retrieved with
     * getSubmitAreaDisplayGroup().
     *
     * @param $label link text
     * @param $name name for the link form element
     * @param $action action for the link
     * @param $controller controller for the link
     * @param $module module for the link
     * @param $params request parameters for the link
     * @param $options options for the link form element
     * 
     * @deprecated Please use addActionUrl instead
     */
    public function addCancelActionUrl($label = 'Cancel', $name = 'cancel', $action, 
            $controller = null, $module = null, 
            array $params = null, array $options = null)
    {
        $this->addActionUrl($label, $name, $action, $controller, $module, $params, $options);
    }


    /**
     * Adds an action url to the submit buttons area of the form. This method is defined
     * here so that we don't bother form developers with placing submit buttons in their
     * dedicated display group. The display group for buttons can be retrieved with
     * getSubmitAreaDisplayGroup().
     *
     * @param $label link text
     * @param $name name for the link form element
     * @param $action action for the link
     * @param $controller controller for the link
     * @param $module module for the link
     * @param $params request parameters for the link
     * @param $options options for the link form element
     */
    public function addActionUrl($label, $name, $action, $controller = null, $module = null, 
            array $params = null, array $options = null)
    {
        $options['action'] = $action;
        $options['controller'] = $controller;
        $options['module'] = $module;
        $options['params'] = $params;
        $options['content'] = $label;
        
        $this->addElement('actionUrl', $name, $options);
        $this->buttonsDisplayGroupElementNames[] = $name;
        $this->createButtonsDisplayGroup($this->buttonsDisplayGroupElementNames);
    }
    
    
    /**
     * Creates (re-creates) the buttons display group with given element names.
     */
    private function createButtonsDisplayGroup(array $elements)
    {
        parent::addDisplayGroup($elements, $this->buttonsDisplayGroupName, array (
                'class' => 'buttons'));
        $this->buttonsDisplayGroup = $this->getDisplayGroup($this->buttonsDisplayGroupName);
        $this->buttonsDisplayGroup->removeDecorator("DtDdWrapper");
        $this->buttonsDisplayGroup->removeDecorator("HtmlTag");
        $this->buttonsDisplayGroup->removeDecorator("Fieldset");
        if ($this->requiredInfo) {
            $this->buttonsDisplayGroup->addDecorator("RequiredInfo");
        }
        $this->buttonsDisplayGroup->addDecorator("Fieldset");
    }


    /**
     * Returns the display group with form buttons or null if no submit buttons have been
     * added to the form.
     */
    public function getSubmitAreaDisplayGroup()
    {
        return $this->buttonsDisplayGroup;
    }


    /**
     * Adds a CSS class to this form.
     */
    public function addClass($cssClass)
    {
        $this->setAttrib('class', OX_UI_Form_Element_Utils::addClass($this->getAttrib('class'), $cssClass));
    }


    /**
     * Overridden to remove Zend's default decorators that would break the layout.
     */
    public function addElement($element, $name = null, $options = null)
    {
        // Add a prefix path for validators
        $prefixPath = null;
        if (isset($options['prefixPath'])) {
            $prefixPath = $options['prefixPath'];
        } else {
            $prefixPath = array ();
        }
        $prefixPath[] = array ('prefix' => 'OX_Common_Validate', 
                'path' => 'OX/Common/Validate', 
                'type' => Zend_Form_Element::VALIDATE);
        $prefixPath[] = array ('prefix' => 'OX_Common_Filter', 
                'path' => 'OX/Common/Filter', 
                'type' => Zend_Form_Element::FILTER);
        
        // For required elements that have a label, add a validator whose message
        // refers specifically to the element name.
        if (!empty($options['label']) && empty($options['requiredMessageLabel'])) {
            $options['requiredMessageLabel'] = $options['label']; 
        }
        
        if (isset($options['required']) && $options['required'] == true && !empty($options['requiredMessageLabel']) && 
            (!isset($options['useLabelInRequiredMessage']) || $options['useLabelInRequiredMessage'] == true))
        {
            $validator = new Zend_Validate_NotEmpty();
            $validator->setMessage($options['requiredMessageLabel'] . ' is required and can\'t be empty');
            if (!isset($options['validators'])) {
                $options['validators'] = array();
            }
            array_unshift($options['validators'], 
                array('validator' => $validator, 'breakChainOnFailure' => true));
        }
        unset($options['requiredMessageLabel']);
        
        // Let Zend build the element for us
        $elementOptions = $options ? $options : array ();
        $elementOptions['prefixPath'] = $prefixPath;
        parent::addElement($element, $name, $elementOptions);
        
        // Remove the dt/dd tags, sometimes these are added with HtmlTag,
        // and sometimes with DtDdWrapper.
        if ($element instanceof Zend_Form_Element) {
            $name = $element->getName();
        }
        $addedElement = $this->getElement($name);
        $addedElement->removeDecorator("HtmlTag");
        $addedElement->removeDecorator("DtDdWrapper");
        
        // We'll add our own error decorator to form lines
        $addedElement->removeDecorator("Errors");
        
        return $this;
    }


    /**
     * Adds a display group with the provided element names to this form. If a display
     * group with the provided name already exists in the form, element will be 
     * appended at the end of the display group.
     */
    public function addDisplayGroup(array $elements, $name, $optionsOrLegend = null)
    {
        if (is_string($optionsOrLegend) && !empty($optionsOrLegend)) {
            $options = array('legend' => $optionsOrLegend);
        } else {
            $options = $optionsOrLegend;
        }
        
        $existingElem = $this->getElement($name);
        if(!empty($existingElem)) {
            throw new Zend_Exception("Display group name '". $name . "' is not unique. There's already form element with this name");    
        }
        
        $addedGroup = $this->getDisplayGroup($name);
        if (!isset($addedGroup)) {
            parent::addDisplayGroup($elements, $name, $options);
            $addedGroup = $this->getDisplayGroup($name);
            
            // Remove the dt/dd tags, sometimes these are added with HtmlTag,
            // and sometimes with DtDdWrapper.
            $addedGroup->removeDecorator("HtmlTag");
            $addedGroup->removeDecorator("DtDdWrapper");
            $addedGroup->removeDecorator("Fieldset");
            
            $addedGroup->addDecorator("SectionFieldset");
        } 
        else {
            if (!empty($options))
            {
                $addedGroup->setOptions($options);
            }
            foreach ($elements as $elementName) {
            	$element = $this->getElement($elementName);
            	if (!isset($element))
            	{
            	    throw new Zend_Form_Exception('Element with name \'' . $elementName . '\' not found');
            	}
            	$addedGroup->addElement($element);
                unset($this->_order[$element->getName()]);
            }
            $this->_addDisplayGroupObject($addedGroup);
        }

        if (isset($options['description'])) {
            $element = $this->getElement(OX_Common_ArrayUtils::first($elements));
            if ($element instanceof OX_UI_Form_Element_Line) {
                $element->setDescription($options['description']);
                OX_Common_ObjectUtils::setOptions($element, $options, array (), array (
                        'descriptionClass', 
                        'descriptionId', 
                        'descriptionType'));
            }
        }
        
        return $this;
    }
    
    
    /**
     * Sets label of the submit button.
     */
    public function setSubmitLabel($submitLabel)
    {
        $this->submitLabel = $submitLabel;
    }


    /**
     * Sets additional options for the submit button. All options of a regular button
     * are supported here.
     */
    public function setSubmitOptions($submitOptions)
    {
        $this->submitOptions = $submitOptions;
    }


    /**
     * Sets a custom message text to be displayed on form validation errors.
     */
    public function setFormValidationErrorMessage($message)
    {
        $this->formValidationErrorMessage = $message;
    }


    public function getFormValidationErrorMessage()
    {
        return $this->formValidationErrorMessage;
    }


    /**
     * Sets custom form-level error message text, independent of form validation messages.
     */
    public function setFormErrorMessage($message)
    {
        $this->setFormMessage($message, 'error');
    }


    /**
     * Sets custom form-level warning message.
     */
    public function setFormWarningMessage($message)
    {
        $this->setFormMessage($message, 'warning');
    }


    /**
     * Sets custom form-level confirmation/ question message.
     */
    public function setFormConfirmMessage($message)
    {
        $this->setFormMessage($message, 'confirm');
    }


    /**
     * Sets custom form-level information message.
     */
    public function setFormInfoMessage($message)
    {
        $this->setFormMessage($message, 'info');
    }


    /**
     * Sets custom form-level message text independent of form validation messages.
     * 
     * @param $message message text
     * @param $messageType message type: 'info', 'confirm', 'warning', 'error'
     */
    public function setFormMessage($message, $messageType = 'info')
    {
        $this->formMessage = $message;
        $this->formMessageType = $messageType;
    }


    public function getFormMessage()
    {
        return $this->formMessage;
    }


    public function getFormMessageType()
    {
        return $this->formMessageType;
    }


    /**
     * Sets this form's id.
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Determines whether the 'Required fields' info should display on this form.
     */
    public function setRequiredInfo($requiredInfo)
    {
        $this->requiredInfo = $requiredInfo;
    }


    /**
     * Register a life cycle listener for this form.
     *
     * @param OX_UI_Form_Listener $listener
     */
    public function addListener(OX_UI_Form_Listener $listener)
    {
        $this->listeners[] = $listener;
        $listener->afterListenerAdded($this);
    }

    
    /**
     * Adds global form validator. Such validators are called after elements and
     * fragments are validated.
     *
     * @param OX_UI_Form_Validate_FormValidator $formValidator
     */
    public function addFormValidator(OX_UI_Form_Validate_FormValidator $formValidator)
    {
        $this->formValidators[] = $formValidator;
    }
    

    public function render(Zend_View_Interface $view = null)
    {
        foreach ($this->listeners as $listener) {
            $listener->beforeRender($this);
        }
        return parent::render($view);
    }

    
    public function isValid($data)
    {
        $valid = parent::isValid($data);
        foreach ($this->listeners as $listener) {
            $valid = $valid && $listener->afterValidation($this, $valid, $data);
        }
        
        $valid = $valid && $this->isFormValid($data);
        
        if ($valid === false) {
            $this->markAsError();
        }
        return $valid && !$this->isErrors();
    }
    
    
    private function isFormValid($data)
    {
        $messages = array();
        $errors   = array();
        $formMessage = null;
        $translator = $this->getTranslator();
        $valid = true;
        
        foreach ($this->formValidators as $validator) {
            if (method_exists($validator, 'setTranslator')) {
                $validator->setTranslator($translator);
            }
            $valid = $valid && $validator->isValid($data);
            
            if ($valid) {
                continue;
            }
            $messages = $validator->getElementMessages();
            $errors   = array_keys($messages);
            $formMessage = $validator->getFormMessage();
            break;
        }
        
        //TODO mark fields in error
        if(!empty($formMessage)) {
            $message = current($formMessage);
            $this->setFormValidationErrorMessage($message);
        }
        foreach ($messages as $elementName => $aElemMessages) {
            $element  = $this->getElement($elementName);
            $element->addErrors(array_values($aElemMessages));
        }
        

        return $valid;
    }
    
    
    /**
     * Shortcut to translate function. Translates the given string
     *
     * @param  string $messageId Translation string
     * @param  string|Zend_Locale $locale    (optional) Locale/Language to use, identical with locale
     *                                       identifier, 
     * @see Zend_Translate_Adapter
     * @return string
     */
    public function t($messageId, $aValues = null, $locale = null)
    {
        return Zend_Registry::get("smartyView")->getHelper('t')->t($messageId, $aValues, $locale);
    }    
}

/**
 * Sets page-level messages
 *
 */
class PageLocalMessageSetter extends OX_UI_Controller_Plugin
{
    private $form;


    public function __construct(OX_UI_Form $form)
    {
        $this->form = $form;
    }


    public function beforeRender(OX_UI_Controller_Default $controller)
    {
        if ($controller instanceof OX_UI_Controller_ContentPage) {
            $this->addMessages($controller);
        }
    }


    private function addMessages(OX_UI_Controller_ContentPage $controller)
    {
        if ($this->form->isErrors()) {
            $controller->setPageLocalMessage(new OX_UI_Message_Text(array (
                    'text' => $this->form->getFormValidationErrorMessage(), 
                    'scope' => 'form', 
                    'type' => 'error')));
        
        }
        elseif ($this->form->getFormMessage()) {
            $controller->setPageLocalMessage(new OX_UI_Message_Text(array (
                    'text' => $this->form->getFormMessage(), 
                    'scope' => 'form', 
                    'type' => $this->form->getFormMessageType())));
        }
    }
}

class FragmentManagerListener extends OX_UI_Form_Listener_Default  
{
    private $fragments;
    private $form;
    
    
    public function __construct(OX_UI_Form $form)
    {
        $this->fragments = array();
        $this->form = $form;
    }
    
    
    public function addFragment(OX_UI_Form_Fragment $fragment)
    {
        $fragment->build($this->form, Zend_Controller_Front::getInstance()->getRequest()->getParams());
        $this->fragments []= $fragment;
    }
    
    
    public function afterValidation(OX_UI_Form $form, $isValid, array $values)
    {
        if (!$isValid)
        {
            return false;
        }
        $valid = $isValid;
        
        foreach ($this->fragments as $fragment) {
            $valid = $valid && $fragment->validate($form, $values);
        }
        
        if ($valid) {
            foreach ($this->fragments as $fragment) {
                $fragment->populate($form);
            }
        }
        
        return $valid;
    }


    public function beforeRender(OX_UI_Form $form)
    {
        foreach ($this->fragments as $fragment) {
            $fragment->render($form);
        }
    }
}
