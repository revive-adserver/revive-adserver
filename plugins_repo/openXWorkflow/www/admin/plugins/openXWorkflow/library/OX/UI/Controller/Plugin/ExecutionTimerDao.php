<?php

interface OX_UI_Controller_Plugin_ExecutionTimerDao
{
    public function logTime($action, $controller, $module, $totalTime, $actionTime);
}