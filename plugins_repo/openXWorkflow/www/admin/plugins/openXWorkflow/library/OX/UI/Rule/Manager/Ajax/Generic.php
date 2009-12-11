<?php

/**
 * A base implementation for managers that manage a fixed list of rule editors.
 */
abstract class OX_UI_Rule_Manager_Ajax_Generic extends OX_UI_Rule_Manager_Ajax
{
    protected $ruleType;
    
    protected $allSupportedRuleEditors;


    public function __construct(OX_UI_Form $form = null, $ruleType = null)
    {
        parent::__construct($form);
        $this->ruleType = $ruleType;
        $this->allSupportedRuleEditors = array();
    }


    public function addGenericRulesDisplayGroup($groupId, $groupLegend, 
            $prependLineNames = array(), $appendLineNames = array())
    {
        foreach ($this->allSupportedRuleEditors as $editor) {
            if (!$editor->isEmpty()) {
                $this->addRuleEditor($editor);
            }
        }
        parent::addRulesDisplayGroup($groupId, $groupLegend, array (), $prependLineNames, $appendLineNames);
    }


    private function addRuleEditorByType($type)
    {
        if (!isset($this->allSupportedRuleEditors[$type])) {
            throw new Exception('Unsupported rule type: ' . $type);
        }
        $this->addRuleEditor($this->allSupportedRuleEditors[$type]);
    }


    public function forRuleAdd()
    {
        $this->addRuleEditorByType($this->ruleType);
        $this->createFormLines(self::ELEMENTS);
        return $this;
    }


    public function forRuleChange()
    {
        return $this->forExistingRule(self::EDIT);
    }


    public function forRuleSaved()
    {
        return $this->forExistingRule(self::SAVED);
    }


    public function forFullRefresh()
    {
        $this->addGenericRulesDisplayGroup('refresh', 'refresh');
        return $this;
    }


    protected function forExistingRule($mode)
    {
        $this->addRuleEditorByType($this->ruleType);
        $this->createFormLines($mode);
        return $this;
    }


    protected function getRuleTypesMultiOptions()
    {
        $options = array (null => $this->getRuleTypeNullLabel());
        foreach ($this->allSupportedRuleEditors as $editor) {
            if ($editor->isEmpty()) {
                $options[$editor->type] = $editor->label;
            }
        }
        return (count($options) > 1 ? $options : null);
    }

    
    protected function getRuleTypeNullLabel()
    {
        return '-- choose rule --';
    }
    
    
    protected function getAddRulePrefix()
    {
        return 'Add new rule';
    }


    protected function getNoMoreRulesPrefix()
    {
        return 'No more rules to add';
    }
}
