<?php

/**
 * Provides empty implementations of the OX_UI_Form_Listener interface. 
 */
class OX_UI_Form_Listener_Default implements OX_UI_Form_Listener
{
    public function afterListenerAdded(OX_UI_Form $form)
    {
    }


    public function afterValidation(OX_UI_Form $form, $isValid, array $values)
    {
        return $isValid;
    }


    public function beforeRender(OX_UI_Form $form)
    {
    }
}
