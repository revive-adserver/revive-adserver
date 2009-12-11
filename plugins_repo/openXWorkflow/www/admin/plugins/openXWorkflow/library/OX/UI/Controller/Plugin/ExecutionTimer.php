<?php

/**
 * Measures time spent on processing a single request and saves it to the database.
 */
class OX_UI_Controller_Plugin_ExecutionTimer extends Zend_Controller_Plugin_Abstract
{
    const TIMER_PRECISION = 5;
    
    /**
     * @var OX_UI_Controller_Plugin_ExecutionTimerDao
     */
    private $timerDao;
    
    /**
     * Time when the whole processing started.
     */
    private $requestStartTimestamp;
    
    /**
     * Time when the whole processing finished.
     */
    private $requestStopTimestamp;
    
    /**
     * An array of times when action processing started. We need an array here
     * because requests can be forwarded between actions. Also, it may happen that
     * e.g because exceptions, a start time for action will be logged, but there
     * will be no stop time. At the end, we'll calculate the sum of correct start/end
     * pairs and assign it to the last handled action/controller/module combo.
     */
    private $actionStartTimestamp = array();
    
    /**
     * An array of times when action processing finished, may contain empty values.
     */
    private $actionStopTimestamp = array();
    
    /**
     * Index of the action being currently measured. There can be many because
     * handling can be forwarded between actions.
     */
    private $currentActionIndex;
    private $action;
    private $controller;
    private $module;


    /**
     * @param $timerDao if a non-null value is provided, the plugin will call the DAO
     * to store time measurements.
     */
    public function __construct(
            OX_UI_Controller_Plugin_ExecutionTimerDao $timerDao = null)
    {
        $this->timerDao = $timerDao;
    }


    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->requestStartTimestamp = microtime(true);
        $this->currentActionIndex = 0;
    }


    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $this->actionStartTimestamp[$this->currentActionIndex++] = microtime(true);
    }


    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Overwrite previous values if any. We'll assign the total action time to the
        // last action/controller/module combo that was handled in the forward chain
        $this->action = $request->getActionName();
        $this->controller = $request->getControllerName();
        $this->module = $request->getModuleName();
        
        $this->actionStopTimestamp[$this->currentActionIndex - 1] = microtime(true);
    }


    public function getTotalTime()
    {
        if (empty($this->requestStartTimestamp) || empty($this->requestStopTimestamp)) {
            return 0;
        }
        return round($this->requestStopTimestamp - $this->requestStartTimestamp, self::TIMER_PRECISION);
    }


    public function getActionTime()
    {
        $time = 0;
        for ($i = 0; $i < $this->currentActionIndex; $i++) {
            if (isset($this->actionStopTimestamp[$i])) {
                $time += $this->actionStopTimestamp[$i] - $this->actionStartTimestamp[$i];
            }
        }
        
        return round($time, self::TIMER_PRECISION);
    }


    public function dispatchLoopShutdown()
    {
        $this->requestStopTimestamp = microtime(true);
        
        // Log only if we know the action/controller/module
        if ($this->timerDao) {
            $totalTime = $this->getTotalTime();
            $actionTime = $this->getActionTime();
            if ($this->action && $this->controller && $this->module && $totalTime > 0 && $actionTime > 0) {
                $this->timerDao->logTime($this->action, $this->controller, $this->module, $totalTime, $actionTime);
            }
        }
    }
}