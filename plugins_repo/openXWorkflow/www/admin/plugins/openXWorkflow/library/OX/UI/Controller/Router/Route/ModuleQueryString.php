<?php
/**
 * This is a custom router using query string to get parameters of the request
 *
 */

/**
 * Module Route
 *
 * Default route for module functionality. Uses query string to obtain module, controller and action name
 *
 */
class OX_UI_Controller_Router_Route_ModuleQueryString 
    extends Zend_Controller_Router_Route_Abstract
{
    /**
     * URI delimiter
     */
    const URI_DELIMITER = '/';

    /**
     * Default values for the route (ie. module, controller, action, params)
     * @var array
     */
    protected $_defaults;

    protected $_values      = array();
    protected $_moduleValid = false;
    protected $_keysSet     = false;

    /**#@+
     * Array keys to use for module, controller, and action. Should be taken out of request.
     * @var string
     */
    protected $_moduleKey     = 'module';
    protected $_controllerKey = 'controller';
    protected $_actionKey     = 'action';
    /**#@-*/

    /**
     * @var Zend_Controller_Dispatcher_Interface
     */
    protected $_dispatcher;

    /**
     * @var Zend_Controller_Request_Abstract
     */
    protected $_request;

    /**
     * Instantiates route based on passed Zend_Config structure
     */
    public static function getInstance(Zend_Config $config)
    {
        $defs = ($config->defaults instanceof Zend_Config) ? $config->defaults->toArray() : array();
        return new self($defs);
    }

    /**
     * Constructor
     *
     * @param array $defaults Defaults for map variables with keys as variable names
     * @param Zend_Controller_Dispatcher_Interface $dispatcher Dispatcher object
     * @param Zend_Controller_Request_Abstract $request Request object
     */
    public function __construct(array $defaults = array(),
                Zend_Controller_Dispatcher_Interface $dispatcher = null,
                Zend_Controller_Request_Abstract $request = null)
    {
        $this->_defaults = $defaults;

        if (isset($request)) {
            $this->_request = $request;
        }

        if (isset($dispatcher)) {
            $this->_dispatcher = $dispatcher;
        }
    }

    /**
     * Set request keys based on values in request object
     *
     * @return void
     */
    protected function _setRequestKeys()
    {
        if (null !== $this->_request) {
            $this->_moduleKey     = $this->_request->getModuleKey();
            $this->_controllerKey = $this->_request->getControllerKey();
            $this->_actionKey     = $this->_request->getActionKey();
        }

        if (null !== $this->_dispatcher) {
            $this->_defaults += array(
                $this->_controllerKey => $this->_dispatcher->getDefaultControllerName(),
                $this->_actionKey     => $this->_dispatcher->getDefaultAction(),
                $this->_moduleKey     => $this->_dispatcher->getDefaultModule()
            );
        }

        $this->_keysSet = true;
    }

    /**
     * Matches a user submitted path. Assigns and returns an array of variables
     * on a successful match.
     *
     * If a request object is registered, it uses its setModuleName(),
     * setControllerName(), and setActionName() accessors to set those values.
     * Always returns the values as an array.
     *
     * @param Zend_Controller_Request_Abstract $request Path used to match against this routing map
     * @return array An array of assigned values or a false on a mismatch
     */
    public function match($request)
    {
        $this->_setRequestKeys();

        $values = array();

        $moduleName = $request->getParam($this->_moduleKey);
        $controllerName = $request->getParam($this->_controllerKey);
        $actionName = $request->getParam($this->_actionKey);
        

        if ($this->_dispatcher && $this->_dispatcher->isValidModule($moduleName)) {
            $values[$this->_moduleKey] = $moduleName;
            $this->_moduleValid = true;
        }

        if (!empty($controllerName)) {
            $values[$this->_controllerKey] = $controllerName;
        }
        
        if (!empty($actionName)) {
            $values[$this->_actionKey] = $actionName;
        }

        $this->_values = $values;

        return $this->_values + $this->_defaults;
    }
    

    /**
     * Assembles user submitted parameters forming a URL path defined by this route
     *
     * @param array $data An array of variable and value pairs used as parameters
     * @param bool $reset Weither to reset the current params
     * @return string Route path with user submitted parameters
     */
    public function assemble($data = array(), $reset = false, $encode = true)
    {
        if (!$this->_keysSet) {
            $this->_setRequestKeys();
        }

        $params = (!$reset) ? $this->_values : array();

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $params[$key] = $value;
            } elseif (isset($params[$key])) {
                unset($params[$key]);
            }
        }

        $params += $this->_defaults;

        $url = '';

        if ($this->_moduleValid || array_key_exists($this->_moduleKey, $params)) {
            $module = $params[$this->_moduleKey];
        }
        unset($params[$this->_moduleKey]);

        $controller = $params[$this->_controllerKey];
        unset($params[$this->_controllerKey]);

        $action = $params[$this->_actionKey];
        unset($params[$this->_actionKey]);

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $arrayValue) {
                    if ($encode) $arrayValue = urlencode($arrayValue);
                    $url .= '&' . $key;
                    $url .= '=' . $arrayValue;
                }
            } else {
                if ($encode) $value = urlencode($value);
                $url .= '&' . $key;
                $url .= '=' . $value;
            }
        }

        if (!empty($url) || (!empty($action) && $action !== $this->_defaults[$this->_actionKey])) {
            if ($encode) $action = urlencode($action);
            $url = '&'.$this->_actionKey. '=' . $action . $url;
        }

        if (!empty($url) || (!empty($controller) && $controller !== $this->_defaults[$this->_controllerKey])) {
            if ($encode) $controller = urlencode($controller);
            $url = '&'.$this->_controllerKey.'='. $controller . $url;
        }

        if (!empty($module) && $module !== $this->_defaults[$this->_moduleKey]) {
            if ($encode) $module = urlencode($module);
            $url = '?'.$this->_moduleKey. '=' . $module . $url;
        }
        $url = strpos($url, '&') === 0 ? preg_replace('/(^&)(\.*)/', '?$2', $url) : $url;  
        
        return $url;
    }
    

    /**
     * Return a single parameter of route's defaults
     *
     * @param string $name Array key of the parameter
     * @return string Previously set default
     */
    public function getDefault($name) {
        if (isset($this->_defaults[$name])) {
            return $this->_defaults[$name];
        }
    }

    /**
     * Return an array of defaults
     *
     * @return array Route defaults
     */
    public function getDefaults() {
        return $this->_defaults;
    }
}
