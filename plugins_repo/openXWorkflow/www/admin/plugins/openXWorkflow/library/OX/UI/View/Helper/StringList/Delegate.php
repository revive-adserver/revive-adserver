<?php

/**
 * Handles specific actions performed by the OX_UI_View_Helper_StringList helper. Please
 * also see OX_UI_View_Helper_StringList_ControllerWrapperDelegate for a default
 * implementation.
 */
interface OX_UI_View_Helper_StringList_Delegate
{
    /**
     * Returns the list of strings to be managed. 
     * 
     * @return an array with one entry per string. Each entry must be an associative array
     *          with two keys: 
     *              'string' containing the string to be displayed on the screen
     *              'id'     parameter required to identify the string during e.g. the 
     *                       remove operation. Note that further parameters, e.g. parent
     *                       entity id, can be passed using the {@link getParams()} method.
     */
    public function listStrings();
    
    /**
     * Invoked after the string being added has been successfully validated. This method
     * is responsible for persisting the changes, generating a confirmation message 
     * for the user and possibly making a redirect after submit (to avoid resubmission).
     * 
     * @param $string string after validation and filtering
     */
    public function addString($string);
    
    /**
     * Invoked after the user requested to remove a number of strings. This method is responsible 
     * for persisting the changes, generating a confirmation message for the user and 
     * possibly making a redirect after submit (to avoid resubmission).
     * 
     * @param $ids ids of strings to be removed as returned by {@link listStrings()}
     */
    public function removeStrings($ids);
    
    /**
     * Invoked when the string being added did not pass validation. 
     * 
     * @param $string the string that did not pass validation
     * @param $errors identifiers of validation errors as from Zend_Validate_Interface::getErrors()
     * @param $messages error messages as from Zend_Validate_Interface::getMessages()
     */
    public function validationError($string, $errors, $messages);

    /**
     * Formats the provided string for inclusion in the strings list. This method can e.g.
     * wrap the string in some HTML tags. Please note that the returned string needs to be 
     * escaped as appropriate.
     * 
     * @param $string unescaped string
     * @return string formatted and escaped string
     */
    public function formatForList($string);

    
    /**
     * Returns the Zend_Filter_Interface filters to be applied before validation.
     * 
     * @return array of filters, can be null, in which case filtering will not be applied.
     */
    public function getFilters();
    
    /**
     * Returns the Zend_Validate_Interface validators to be applied.
     * 
     * @return array of validators, can be null, in which case validation will not be performed.
     */
    public function getValidators();

    
    /**
     * @return string the name of action that should handle all operations of this helper.
     *          Can be <code>null</code> in which case the current action will be used.
     */
    public function getAction();
    
    
    /**
     * @return string the name of controller that should handle all the actions. Can be
     *          <code>null</code> in which case the current controller will be used.
     */
    public function getController();
    
    /**
     * @return string the name of module that should handle all the actions. Can be
     *          <code>null</code> in which case the current module will be used.
     */
    public function getModule();
    
    /**
     * @return array custom parameters to be appended to all urls. This can be e.g. the
     *          identifier of the parent entity to which the strings are added. 
     *          Can be <code>null</code>.
     */
    public function getParams();
}
