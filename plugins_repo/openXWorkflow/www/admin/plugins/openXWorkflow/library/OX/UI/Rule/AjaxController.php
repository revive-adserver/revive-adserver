<?php

abstract class OX_UI_Rule_AjaxController extends OX_UI_Controller_Default
{
    abstract protected function createManager();


    protected function createManagerForRuleAdd()
    {
        return $this->createManager()->forRuleAdd();
    }


    protected function createManagerForRuleChange()
    {
        return $this->createManager()->forRuleChange();
    }


    protected function createManagerForRuleSaved()
    {
        return $this->createManager()->forRuleSaved();
    }


    protected function createManagerForFullRefresh()
    {
        return $this->createManager()->forFullRefresh();
    }


    public function emptyRuleFormAction()
    {
        $this->noViewScript($this->createManagerForRuleAdd()->getForm(), true);
    }


    public function populatedRuleFormAction()
    {
        $manager = $this->createManagerForRuleChange();
        $manager->populateForm();
        
        $this->noViewScript($manager->getForm(), true);
    }
    

    public function saveRuleAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->noViewScript('', true);
            return;
        }
        
        $manager = $this->createManagerForRuleChange();
        
        $manager->getForm()->populate($_POST);
        $manager->populateRule();
        
        $this->noViewScript($this->createManagerForRuleSaved()->getForm(), true);
    }


    public function addRuleAction()
    {
        $this->_helper->layout->disableLayout();
        if (!$this->getRequest()->isPost()) {
            $this->noViewScript('', true);
            return;
        }
        
        $manager = $this->createManagerForRuleAdd();
        $manager->getForm()->populate($_POST);
        $manager->addRules();
        
        $this->noViewScript($this->createManagerForFullRefresh()->getForm(), true);
    }


    public function removeRuleAction()
    {
        $manager = $this->createManagerForRuleChange();
        $manager->removeRules();
        
        $this->noViewScript($this->createManagerForFullRefresh()->getForm(), true);
    }
}
