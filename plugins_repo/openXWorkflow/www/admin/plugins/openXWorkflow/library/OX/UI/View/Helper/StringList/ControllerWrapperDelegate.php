<?php

/**
 * An implementation of OX_UI_View_Helper_StringList_Delegate that wraps an instance of
 * OX_UI_Controller_ContentPage. A controller instance is available as a field and can be used
 * e.g. to display confirmation messages and perform redirects.
 */
abstract class OX_UI_View_Helper_StringList_ControllerWrapperDelegate implements 
        OX_UI_View_Helper_StringList_Delegate
{
    /**
     * The wrapped controller.
     * 
     * @var OX_UI_Controller_ContentPage
     */
    protected $wrappedController;
    
    private $validators;
    private $filters;
    
    private $action;
    private $controller;
    private $module;
    private $params = array ();
    
    private $addedMessagePrefix = 'String';
    private $addedMessageSuffix = 'has been added to the list';
    private $oneRemovedMessagePrefix = 'String';
    private $oneRemovedMessageSuffix = 'has been removed from the list';
    private $manyRemovedMessagePrefix = '';
    private $manyRemovedMessageSuffix = 'strings have been removed from the list';
    private $errorMessagePrefix = 'Please correct the following errors to add the string:';


    public function __construct(OX_UI_Controller_ContentPage $controller, 
            array $options = array())
    {
        $this->wrappedController = $controller;
        OX_Common_ObjectUtils::setOptions($this, $options, array (
                'wrappedController'));
    }


    public final function addString($string)
    {
        $this->addStringInternal($string);
        
        $this->wrappedController->redirectWithPageLocalMessageAndPayload(array (
                'text' => $this->addedMessagePrefix . ' ' . $this->formatForMessage($string) . ' ' . $this->addedMessageSuffix, 
                'type' => 'confirm'), array (
                'addedString' => $string), $this->getAction(), $this->getController(), $this->getModule(), $this->getParams());
    }


    /**
     * Formats the provided string for inclusion in the message. This method can e.g.
     * wrap the string in some HTML tags. The default implementation wraps the string in
     * &lt;b&gt; tags. Please note that the returned string needs to be escaped as 
     * appropriate.
     * 
     * @param $string unescaped string
     * @return string formatted and escaped string
     */
    protected function formatForMessage($string)
    {
        return !empty($string) ? '<b>' . htmlspecialchars($string) . '</b>' : '';
    }


    /**
     * Formats the provided string for inclusion in the strings list. This method can e.g.
     * wrap the string in some HTML tags. Please note that the returned string needs to be 
     * escaped as appropriate. This implementation returns the escaped input string.
     * 
     * @param $string unescaped string
     * @return string formatted and escaped string
     */
    public function formatForList($string)
    {
        return htmlspecialchars($string);
    }


    /**
     * Custom code related to adding a string. Most probably this code will just need to
     * persist the changes. Everything else (confirmation messages, redirects) will be
     * handled by {@link addString()}.
     * 
     * @param $string see {@link addString()} 
     */
    protected abstract function addStringInternal($string);


    public final function removeStrings($strings)
    {
        $stringTexts = $this->removeStringsInternal($strings);
        if (count($stringTexts) == 1) {
            $message = $this->oneRemovedMessagePrefix . ' ' . 
                       $this->formatForMessage($stringTexts[0]) . ' ' . 
                       $this->oneRemovedMessageSuffix;
        } else {
            $message = $this->manyRemovedMessagePrefix . ' ' . 
                       count($stringTexts) . ' ' . $this->manyRemovedMessageSuffix;
        }
        
        $this->wrappedController->redirectWithPageLocalMessage(array (
                'text' => $message, 
                'type' => 'confirm'), $this->getAction(), $this->getController(), $this->getModule(), $this->getParams());
    }


    /**
     * Custom code related to removing strings. Most probably this code will just need to
     * persist the changes. Everything else (confirmation messages, redirects) will be
     * handled by {@link removeString()}.
     * 
     * @param $strings see {@link addString()} 
     * @return the string texts that have just been removed or <code>null</code> if the
     *          string texts are not available at this point any more. 
     */
    protected abstract function removeStringsInternal($strings);


    /**
     * Outputs the validation error messages in a local error message box.
     */
    public function validationError($string, $errors, $messages)
    {
        if (count($messages) == 0) {
            return;
        }
        
        $messageText = $this->errorMessagePrefix . '<ul>';
        foreach ($messages as $message) {
            $messageText .= '<li>' . htmlspecialchars($message) . '</li>';
        }
        $messageText .= '</ul>';
        
        $this->displayError($messageText);
    }


    /**
     * Displays the provided error message on the screen.
     *  
     * @param $messageText
     */
    protected function displayError($messageText)
    {
        $this->wrappedController->setPageLocalMessage(array (
                'text' => $messageText, 
                'type' => 'error'));
    }


    public function setParams($params)
    {
        $this->params = $params;
    }


    public function setModule($module)
    {
        $this->module = $module;
    }


    public function setController($controller)
    {
        $this->controller = $controller;
    }


    public function setAction($action)
    {
        $this->action = $action;
    }


    public function setFilters($filters)
    {
        $this->filters = $filters;
    }


    public function setValidators($validators)
    {
        $this->validators = $validators;
    }


    public function getModule()
    {
        return $this->module;
    }


    public function getController()
    {
        return $this->controller;
    }


    public function getAction()
    {
        return $this->action;
    }


    public function getFilters()
    {
        return $this->filters;
    }


    public function getValidators()
    {
        return $this->validators;
    }


    public function setOneRemovedMessageSuffix($removedMessageSuffix)
    {
        $this->oneRemovedMessageSuffix = $removedMessageSuffix;
    }


    public function setOneRemovedMessagePrefix($removedMessagePrefix)
    {
        $this->oneRemovedMessagePrefix = $removedMessagePrefix;
    }


    public function setManyRemovedMessageSuffix($manyRemovedMessageSuffix)
    {
        $this->manyRemovedMessageSuffix = $manyRemovedMessageSuffix;
    }


    public function setManyRemovedMessagePrefix($manyRemovedMessagePrefix)
    {
        $this->manyRemovedMessagePrefix = $manyRemovedMessagePrefix;
    }


    public function setAddedMessageSuffix($addedMessageSuffix)
    {
        $this->addedMessageSuffix = $addedMessageSuffix;
    }


    public function setAddedMessagePrefix($addedMessagePrefix)
    {
        $this->addedMessagePrefix = $addedMessagePrefix;
    }


    public function getParams()
    {
        return $this->params;
    }
}
