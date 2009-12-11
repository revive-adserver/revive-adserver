<?php

class OX_UI_Controller_Plugin_DefaultExecutionTimerDao implements 
        OX_UI_Controller_Plugin_ExecutionTimerDao
{
    public function logTime($action, $controller, $module, $totalTime, $actionTime)
    {
        $oExecData = new AppExecutionData();
        $oExecData->setModule($module);
        $oExecData->setController($controller);
        $oExecData->setAction($action);
        $oExecData->setApplicationDuration($totalTime);
        $oExecData->setActionDuration($actionTime);
        $oExecData->save();
    }
}