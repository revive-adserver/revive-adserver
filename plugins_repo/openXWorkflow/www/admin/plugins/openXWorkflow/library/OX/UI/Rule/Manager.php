<?php

/**
 */
class OX_UI_Rule_Manager
{
    /**
     * @var OX_UI_Form
     */
    protected $form;
    
    protected $ruleEditors = array ();


    public function __construct(OX_UI_Form $form)
    {
        $this->form = $form;
    }


    public function addRuleEditor(OX_UI_Rule $editor)
    {
        $this->ruleEditors[] = $editor;
    }


    public function populateForm()
    {
        foreach ($this->ruleEditors as $ruleEditor) {
            $ruleEditor->populateForm($this->form);
        }
    }


    public function populateRule()
    {
        foreach ($this->ruleEditors as $ruleEditor) {
            $ruleEditor->populateRule($this->form);
        }
    }


    public function getForm()
    {
        return $this->form;
    }


    public function addRulesDisplayGroup($groupId, $groupLegend, 
            $groupOptions = array(), 
            $prependLineNames = array(), 
            $appendLineNames = array(), 
            $hideWhenEmpty = false)
    {
        // Add rule editors
        $lineNames = array ();
        if (count($this->ruleEditors) > 0) {
            foreach ($this->ruleEditors as $rule) {
                $lineNames[] = $this->addRuleDisplayGroupLine($rule);
            }
        }
        else {
            $emptyRuleSetLineName = $this->addEmptyRuleSetLine();
            if ($emptyRuleSetLineName) {
                $lineNames[] = $emptyRuleSetLineName;
            }
        }
        
        // Add extra custom lines
        $customLines = $this->addCustomRuleDisplayGroupLines();
        if ($customLines) {
            $lineNames = array_merge($lineNames, (array) $customLines);
        }
        
        if (count($lineNames) == 0) {
            return $lineNames;
        }
        
        // Hide group if empty
        if ($hideWhenEmpty) {
            $empty = true;
            foreach ($this->ruleEditors as $rule) {
                $empty = $empty && $rule->isEmpty();
            }
            
            if ($empty) {
                OX_UI_Form_Element_Utils::addClassInOptions($groupOptions, 'minimized');
            }
        }
        
        // Add display group
        $this->form->addDisplayGroup(array_merge($prependLineNames, $lineNames, $appendLineNames), $groupId, array_merge(array (
                'legend' => $groupLegend, 
                'id' => $groupId), $groupOptions));
        return $lineNames;
    }


    protected function addEmptyRuleSetLine()
    {
        return null;
    }


    protected function addRuleEditLine(OX_UI_Rule $rule)
    {
        return $rule->addRuleWithLine($this->form);
    }


    protected function addRuleDisplayGroupLine(OX_UI_Rule $rule)
    {
        return $this->addRuleEditLine($rule);
    }


    protected function addCustomRuleDisplayGroupLines()
    {
    }
}