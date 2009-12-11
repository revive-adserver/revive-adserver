<?php

/**
 * 
 */
abstract class OX_UI_Rule_Manager_Ajax extends OX_UI_Rule_Manager
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const SAVED = 'saved';
    const ELEMENTS = 'elements';


    public function __construct(OX_UI_Form $form = null)
    {
        if (!$form) {
            $form = new OX_UI_Form();
        }
        parent::__construct($form);
    }


    public function addRulesDisplayGroup($groupId, $groupLegend, 
            $groupOptions = array(), 
            $prependLineNames = array(), 
            $appendLineNames = array(), 
            $hideWhenEmpty = false)
    {
        $options = '';
        $options .= 'emptyFormUrl: "' . $this->getEmptyFormUrl() . '"';
        $options .= ', allowEmptyMulticheckboxSelections: ' . ($this->getAllowEmptyMulticheckboxSelections() ? 'true' : 'false');
        
        OX_UI_View_Helper_InlineScriptOnce::inline('$("#' . $groupId . '").ruleEditor({' . $options . '})');
        return parent::addRulesDisplayGroup($groupId, $groupLegend, $groupOptions, $prependLineNames, $appendLineNames);
    }


    protected function getAllowEmptyMulticheckboxSelections()
    {
        return false;
    }


    public function addRules()
    {
        $added = array ();
        foreach ($this->ruleEditors as $ruleEditor) {
            $added[] = $ruleEditor->addRule($this->form);
        }
        $this->saveChanges();
        return $added;
    }


    public function removeRules()
    {
        foreach ($this->ruleEditors as $ruleEditor) {
            $ruleEditor->removeRule();
        }
        $this->saveChanges();
    }


    public function populateRule()
    {
        parent::populateRule();
        $this->saveChanges();
    }


    protected abstract function saveChanges();


    public abstract function forRuleAdd();


    public abstract function forRuleChange();


    public abstract function forRuleSaved();


    public abstract function forFullRefresh();

    
    protected abstract function getControllerName();
    
    
    protected abstract function getModuleName();
    

    public function createFormLines($mode)
    {
        foreach ($this->ruleEditors as $editor) {
            switch ($mode) {
                case self::VIEW :
                    $this->addRuleViewLine($editor);
                    break;
                
                case self::EDIT :
                    $this->addRuleEditLine($editor);
                    break;
                
                case self::SAVED :
                    $this->addRuleSavedLine($editor);
                    break;
                
                case self::ELEMENTS :
                    $this->addRuleElementsLine($editor);
                    break;
                
                default :
                    throw new Exception('Unknown mode:' . $mode);
            }
        }
    }


    protected function addRuleDisplayGroupLine(OX_UI_Rule $rule)
    {
        return $this->addRuleViewLine($rule);
    }


    protected function addCustomRuleDisplayGroupLines()
    {
        return $this->addRuleAddLine();
    }


    protected function addEmptyRuleSetLine()
    {
        $lineName = $this->getHtmlId('EmptyRuleSetLine');
        $this->form->addElementWithLine('content', $this->getHtmlId('EmptyRuleSet'), $lineName, array (
                'content' => $this->getEmptyRuleSetMessage()), array (
                'class' => 'ruleMessageLine compact'));
        return $lineName;
    }


    protected abstract function getEmptyRuleSetMessage();


    protected final function addRuleViewLine(OX_UI_Rule $rule)
    {
        $lineName = $rule->getLineName();
        
        $this->form->addElementWithLine('content', $rule->getHtmlId() . 'Value', $lineName, array (
                'content' => $rule->renderRuleExpression(), 
                'li_title' => 'Click to edit', 
                'li_class' => 'ruleExpr'), array (
                'class' => 'ruleLine ruleViewLine'));
        $this->form->addElementWithLine('link', $rule->getHtmlId('EditLink'), $lineName, array (
                'text' => 'Edit', 
                'href' => $this->getPopulatedFormUrl($rule->getRuleInstanceParams()), 
                'li_class' => 'ruleEdit', 
                'class' => 'ruleEditLink'));
        $this->form->addElementWithLine('link', $rule->getHtmlId('RemoveLink'), $lineName, array (
                'text' => 'Remove', 
                'href' => $this->getRemoveUrl($rule->getRuleInstanceParams()), 
                'li_class' => 'ruleRemove', 
                'class' => 'ruleRemoveLink'));
        $this->form->addElementWithLine('progress', $rule->getHtmlId('Loading'), $lineName, array (
                'li_class' => 'ruleLoading hide', 
                'class' => ''));
        
        return $lineName;
    }


    protected final function addRuleSavedLine(OX_UI_Rule $rule)
    {
        $lineName = $this->addRuleViewLine($rule);
        $this->form->addElementWithLine('divider', $rule->getHtmlId('savedDivider'), $lineName, array (
                'compact' => true));
        $this->form->addElementWithLine('content', $rule->getHtmlId('SavedMessage'), $lineName, array (
                'content' => '<span class="inlineIcon iconConfirm">Changes saved</span>', 
                'li_class' => 'ruleChangesSaved'));
        return $lineName;
    }


    protected final function addRuleEditLine(OX_UI_Rule $rule)
    {
        $lineName = parent::addRuleEditLine($rule);
        $this->form->addElementWithLine('divider', $rule->getHtmlId('saveDivider'), $lineName, array (
                'compact' => true));
        $this->form->addElementWithLine('link', $rule->getHtmlId('Save'), $lineName, array (
                'text' => 'Save Changes', 
                'class' => 'ruleSaveLink', 
                'href' => $this->getSaveUrl($rule->getRuleInstanceParams())));
        $this->form->addElementWithLine('link', $rule->getHtmlId('Cancel'), $lineName, array (
                'text' => 'Cancel', 
                'li_class' => 'ruleCancel', 
                'class' => 'ruleCancelLink', 
                'href' => '#'));
        $this->form->addElementWithLine('progress', $rule->getHtmlId('Saving'), $lineName, array (
                'text' => 'Saving...', 
                'li_class' => 'ruleSaving hide', 
                'class' => ''));
    }


    protected final function addRuleElementsLine(OX_UI_Rule $rule)
    {
        $rule->addRuleElementsWithLine($this->form);
    }


    protected final function addRuleAddLine()
    {
        $lineName = $this->getHtmlId('Line');
        $ruleOptions = $this->getRuleTypesMultiOptions();
        
        if ($ruleOptions) {
            $this->form->addElementWithLine('content', $this->getHtmlId('Prefix'), $lineName . 'Prefix', array (
                    'content' => $this->getAddRulePrefix()), array (
                    'class' => 'ruleMessageLine'));
            
            $selectName = $this->getManagerId() . 'Select';
            $this->form->addElementWithLine('select', $selectName, $lineName, array (
                    'class' => 'addRuleSelect', 
                    'multiOptions' => $ruleOptions, 
                    'width' => OX_UI_Form_Element_Widths::MEDIUM_LARGE), array (
                    'class' => 'ruleLine ruleAddLine'));
            $this->form->addElementWithLine('progress', $this->getHtmlId('AddLoading'), $lineName, array (
                    'li_class' => 'ruleAddLoading hide', 
                    'class' => ''));
            $this->form->addElementWithLine('divider', $this->getHtmlId('saveDivider'), $lineName, array (
                    'compact' => true));
            $this->form->addElementWithLine('link', $this->getHtmlId('Add'), $lineName, array (
                    'text' => 'Add', 
                    'li_class' => 'ruleAdd', 
                    'class' => 'ruleAddLink', 
                    'href' => $this->getAddUrl()));
            $this->form->addElementWithLine('link', $this->getHtmlId('CancelAdd'), $lineName, array (
                    'text' => 'Cancel', 
                    'li_class' => 'ruleCancelAdd hide', 
                    'class' => 'ruleCancelAddLink', 
                    'href' => '#'));
            $this->form->addElementWithLine('progress', $this->getHtmlId('Adding'), $lineName, array (
                    'text' => 'Adding...', 
                    'li_class' => 'ruleAdding hide', 
                    'class' => ''));
            return array ($lineName . 'Prefix', 
                    $lineName);
        }
        else {
            $this->form->addElementWithLine('content', $this->getHtmlId('Prefix'), $lineName . 'Prefix', array (
                    'content' => $this->getNoMoreRulesPrefix()), array (
                    'class' => 'addRulePrefix'));
            return array ($lineName . 'Prefix');
        }
    
    }


    protected abstract function getAddRulePrefix();


    protected abstract function getNoMoreRulesPrefix();


    protected abstract function getRuleTypesMultiOptions();


    protected abstract function getManagerId();

    
    protected abstract function getRuleContainerInstanceParams();
    

    protected final function getHtmlId($suffix = '')
    {
        return $this->getManagerId() . $suffix;
    }


    protected function getEmptyFormUrl()
    {
        return $this->getRulesUrl('empty-rule-form', array (
                'ruleType' => ''));
    }


    protected function getPopulatedFormUrl($params)
    {
        return $this->getRulesUrl('populated-rule-form', $params);
    }


    protected function getAddUrl()
    {
        $params = $this->getRuleContainerInstanceParams();
        $params['ruleType'] = '';
        return $this->getRulesUrl('add-rule', $params);
    }


    protected function getSaveUrl($params)
    {
        return $this->getRulesUrl('save-rule', $params);
    }


    protected function getRemoveUrl($params)
    {
        return $this->getRulesUrl('remove-rule', $params);
    }


    protected function getRulesUrl($action, $params = array())
    {
        return OX_UI_View_Helper_ActionUrl::actionUrl($action, $this->getControllerName(), 
            $this->getModuleName(), $params);
    }
}