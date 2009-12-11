<?php

/**
 * A helper that manages a list of strings. Please also see 
 * OX_UI_View_Helper_ActionUrl_Delegate and OX_UI_View_Helper_ActionUrl_ControllerWrapperDelegate.
 */
class OX_UI_View_Helper_StringList extends OX_UI_View_Helper_WithViewScript
{
    public function stringList(OX_UI_View_Helper_StringList_Delegate $delegate, array $params = array())
    {
        $strings = $delegate->listStrings();
        foreach ($strings as &$string) {
            $string['params']['id'] = $string['id'];
            $string['params']['operation'] = 'remove';
            OX_Common_ArrayUtils::addAll($string['params'], $delegate->getParams());
            $string['formatted'] = $delegate->formatForList($string['string']);
        }

        // A little hack here. OX_UI_View_Helper_StringList_ControllerWrapperDelegate
        // passes some variables to the view of the redirected controller, but this helper
        // is using a partial to render, so the view's variable is not available. Therefore,
        // we need to fetch it from the view and add to the model manually. 
        $view = Zend_Registry::get('smartyView');
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $model = array(
            'strings' => $strings,
            'currentString' => OX_Common_ObjectUtils::getDefault($request->getParam('string'), $view->currentString),
            'addedString' => $view->addedString,
            'action' => OX_Common_ObjectUtils::getDefault($delegate->getAction(), $request->getActionName()),
            'controller' => $delegate->getController(),
            'module' => $delegate->getModule(),
            'params' => $delegate->getParams(),
            'inputPrefix' => OX_Common_ArrayUtils::getDefault($params, 'inputPrefix'),
            'addButtonLabel' => OX_Common_ArrayUtils::getDefault($params, 'addButtonLabel', 'Add string'),
            'listHeader' => OX_Common_ArrayUtils::getDefault($params, 'listHeader', 'String'),
            'emptyListMessage' => OX_Common_ArrayUtils::getDefault($params, 'emptyListMessage', 'No strings on the list'),
            'helpText' => OX_Common_ArrayUtils::getDefault($params, 'helpText'),
        );
        
        return parent::renderViewScript('string-list.html', $model);
    }
    
    
    public static function handle(OX_UI_Controller_Default $controller, 
        OX_UI_View_Helper_StringList_Delegate $delegate)
    {
        $request = $controller->getRequest();
        $operation = $request->getParam('operation');
        switch ($operation)
        {
            case 'bulkRemove':
                $ids = array_values($request->getParam('id'));
                if (!empty($ids)) {
                    $delegate->removeStrings($ids);
                }
                break;
                
            case 'remove':
                $params = OX_UI_Controller_Request_RequestUtils::getNonFrameworkParams($request);
                unset($params['operation']);
                $delegate->removeStrings(array($params['id']));
                break;
                
            case 'add':
                $string = $request->getParam('string');
                
                // Filter the string first
                $filters = $delegate->getFilters();
                if ($filters) {
                    foreach ($filters as $filter) {
                        $string = $filter->filter($string);
                    }
                }
                
                // By default we don't add blank strings
                if (strlen(preg_replace('/\s/', '', $string)) == 0) {
                    $controller->redirectWithPayload(array('currentString' => $string),
                        $delegate->getAction(), $delegate->getController(), 
                        $delegate->getModule(), $delegate->getParams());
                }
                
                // Validate the string
                $valid = true;
                $validators = $delegate->getValidators();
                if ($validators) { 
                    $validationErrors = array();
                    $validationMessages = array();
                    foreach ($validators as $validator) {
                        $v = $validator->isValid($string);
                        $valid = $valid & $v;
                        if (!$v) {
                            $validationErrors = array_merge($validationErrors, $validator->getErrors());
                            $validationMessages = array_merge($validationMessages, $validator->getMessages());
                        }
                    }
                }
                
                if (!$valid) {
                    $request->setParam('string', $string); // replace raw string with filtered
                    $delegate->validationError($string, $validationErrors, $validationMessages);
                } else {
                    $delegate->addString($string);
                }
                break;
        }
    }
}
