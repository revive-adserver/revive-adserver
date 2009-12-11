<?php
require_once SMARTY_LIB_PATH.'/Smarty.class.php';

/**
 * A view helper called by the compiled smarty templates. This is required to support
 * shorthands for calling ZF view helpers from smarty templates.
 */
class OX_UI_Smarty_SmartyWithViewHelper extends Smarty
{
    private $_zendView;

    public function __construct()
    {
        parent::__construct();
        $this->compiler_class = 'OX_UI_Smarty_SmartyCompilerWithViewHelper';
    }

    public function setZendView(Zend_View_Abstract $view)
    {
        $this->_zendView = $view;
    }

    public function callViewHelper($name, $args)
    {
        $helper = $this->_zendView->getHelper($name);
        return call_user_func_array(array($helper, $name), $args);
    }
}
