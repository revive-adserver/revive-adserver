<?php

/**
 * A View that renders content using Smarty templates.
 */
class OX_UI_View_SmartyView extends Zend_View_Abstract
{
    /**
     * Smarty engine used to render the view.
     * 
     * @var OX_UI_Smarty_SmartyWithViewHelper
     */
    protected $_smarty;
    
    private $_noViewScript;
    private $_noViewScriptContent;
    private $_viewScriptName;
    
    public function __construct($config = array())
    {
        parent::__construct($config);
        
        $this->_smarty = new OX_UI_Smarty_SmartyWithViewHelper();
        
        if (!isset($config ['compileDir'])) {
            throw new Exception('compileDir is not set for ' . get_class($this));
        } else {
            $this->_smarty->compile_dir = $config ['compileDir'];
        }
        
        if (isset($config ['configDir'])) {
            $this->_smarty->config_dir = $config ['configDir'];
        }
        
        if (isset($config ['pluginDir'])) {
            $this->_smarty->plugin_dir [] = $config ['pluginDir'];
        }
        
        $this->_smarty->register_modifier('project', array (
                'OX_Common_ArrayUtils', 
                'project'));
        
        $this->_smarty->setZendView($this);
    }
    
    public function getEngine()
    {
        return $this->_smarty;
    }
    
    public function __set($key, $val)
    {
        $this->_smarty->assign($key, $val);
    }
    
    public function __get($key)
    {
        return $this->_smarty->get_template_vars($key);
    }
    
    public function __isset($key)
    {
        $var = $this->_smarty->get_template_vars($key);
        if ($var)
            return true;
        
        return false;
    }
    
    public function __unset($key)
    {
        $this->_smarty->clear_assign($key);
    }
    
    public function assign($spec, $value = null)
    {
        if ($value === null) {
            $this->_smarty->assign($spec);
        } else {
            $this->_smarty->assign($spec, $value);
        }
    }
    
    public function clearVars()
    {
        $this->_smarty->clear_all_assign();
    }
    
    protected function _run()
    {
        $this->strictVars(true);
        
        $this->_smarty->assign_by_ref('this', $this);
        
        $fileName = func_get_arg(0);
        $this->_smarty->template_dir = ".";
        
        // We don't need to include the full path in the id, but just the part
        // that makes the id unique. The trimming will help Windows-based developers
        // not to hit the 255 characters file name limit, which causes strange-looking errrors. 
        $this->_smarty->compile_id = substr($fileName, strlen(MODULES_PATH));
        
        echo $this->_smarty->fetch($fileName);
    }
    
    function __clone()
    {
        $this->_smarty = clone $this->_smarty;
    }
    
    /**
     * Call this method if there is no view script corresponding to the action being 
     * handled. This is useful to get rid of empty view scripts that existed only to 
     * stop Zend_View from throwing exceptions.
     */
    public function noViewScript($replacementContent = '')
    {
        $this->_noViewScript = true;
        $this->_noViewScriptContent = $replacementContent;
    }
    
    /**
     * Sets an alternative view script to be rendered
     */
    public function setViewScript($scriptName)
    {
        $this->_viewScriptName = $scriptName;
    }
    
    
    /**
     * Overriden to handle calls to noViewScript().
     */
    public function render($name)
    {
        if ($this->_noViewScript) {
            // If the caller declared that there is no view script for this rendering,
            // just return empty content.
            $this->_noViewScript = false;
            return $this->_noViewScriptContent;
        }
        else
        {    
            $viewScript = $name;
            if (!empty($this->_viewScriptName)) {
                $viewScript = $this->_viewScriptName;
                $this->_viewScriptName = null;
            }
            
            // Act as usual
            return parent::render($viewScript);
        }
    }
}
