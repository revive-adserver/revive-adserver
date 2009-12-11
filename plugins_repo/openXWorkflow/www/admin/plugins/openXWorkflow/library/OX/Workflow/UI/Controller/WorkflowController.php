<?php


class OX_Workflow_UI_Controller_WorkflowController 
    extends OX_UI_Controller_ContentPage
{
    private $oxWorkflowComponent;
    
    public function preDispatch()
    {
        parent::preDispatch();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->setLayout('layout-wizard');
        }
    }
    
    /**
     * Returns openXWorkflow Plugin Component
     *
     * @return Plugins_admin_openXWorkflow_openXWorkflow
     */
    protected function getOxWorkflowComponent()
    {
        if ($this->oxWorkflowComponent == null) {
            $this->oxWorkflowComponent = OX_Component::factory('admin', 'openXWorkflow');
        }
        
        return $this->oxWorkflowComponent;
    }
}

?>