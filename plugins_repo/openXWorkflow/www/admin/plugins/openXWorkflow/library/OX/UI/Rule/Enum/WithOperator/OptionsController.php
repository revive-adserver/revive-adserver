<?php

/**
 * A controller that serves the lazy-loaded options for enum rule editors.
 */
abstract class OX_UI_Rule_Enum_WithOperator_OptionsController extends OX_UI_Controller_Default
{
    protected abstract function createRuleEditorForType($type);
    
    public function optionsAction()
    {
        $type = $this->_request->getParam('type');
        if (empty($type))
        {
            throw new Exception('Unknown type');
        }
        
        $ruleEditor = $this->createRuleEditorForType($type);
        $form = new OX_UI_Form();
        $ruleEditor->addEnumOptionsElementWithLine($form);
        $this->noViewScript($form->render($this->view), true);
    }
}
