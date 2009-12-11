<?php

/**
 * Default implementation of OX_UI_Form_Fragment with empty implementation of all
 * life cycle methods.
 */
class OX_UI_Form_Fragment_Default implements OX_UI_Form_Fragment
{
    public function build(OX_UI_Form $form, array $values)
    {
    }


    public function populate(OX_UI_Form $form)
    {
    }


    public function validate(OX_UI_Form $form, array $values)
    {
        return true;
    }


    public function render(OX_UI_Form $form)
    {
    }
}
