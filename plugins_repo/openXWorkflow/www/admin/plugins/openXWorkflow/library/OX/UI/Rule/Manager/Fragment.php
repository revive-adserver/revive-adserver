<?php

/**
 * A fragment that contains all rule editors of an OX_UI_Rule_Manager.
 */
class OX_UI_Rule_Manager_Fragment extends OX_UI_Form_Fragment_Alternative
{
    /**
     * @var OX_UI_Rule_Manager
     */
    private $manager;

    private $groupId; 
    private $groupLegend;
    private $hideWhenEmpty;

    
    public function __construct(OX_UI_Rule_Manager $manager, $groupId, 
            $groupLegend, $hideWhenEmpty = false)
    {
        $this->groupId = $groupId;
        $this->groupLegend = $groupLegend;
        $this->hideWhenEmpty = $hideWhenEmpty;
        $this->manager = $manager;
    }


    public function build(OX_UI_Form $form, array $values)
    {
        $this->manager->addRulesDisplayGroup($this->groupId, $this->groupLegend, array (), 
            array (), array (), $this->hideWhenEmpty);
        $this->manager->populateForm();
    }


    public function populateInternal(OX_UI_Form $form)
    {
        $this->manager->populateRule();
    }
    
    
    public function getControlledDisplayGroupNames()
    {
        return array($this->groupId);
    }
}
