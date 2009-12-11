<?php

/**
 * Defines a number of form life cycle events applications can react to.
 */
interface OX_UI_Form_Listener
{
    /**
     * Invoked right after this listener has been added to the form.
     *
     * @param OX_UI_Form $form
     */
    public function afterListenerAdded(OX_UI_Form $form);
    
    /**
     * Invoked after the default form validation is performed. This listener may be useful
     * to perform additional form-level validation and register additional errors. 
     *
     * @param OX_UI_Form $form
     */
    public function afterValidation(OX_UI_Form $form, $isValid, array $values);
    
    /**
     * Invoked before the form renders
     *
     * @param OX_UI_Form $form
     */
    public function beforeRender(OX_UI_Form $form);
}
