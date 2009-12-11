<?php

/**
 * Resolves the menu section based on the request, if any. Also performs screen-level
 * access checks.
 */
class OX_UI_Controller_Plugin_MenuSectionResolver extends OX_UI_Controller_Plugin
{
    public function preDispatch(OX_UI_Controller_Default $controller)
    {
        // Resolve menu section
        $request = $controller->getRequest();
        $section = OX_UI_Menu::getFromRegistry()->getSectionForRequest($request);
        if ($section !== null) {
            $controller->view->section = $section;
            
            if (!$section->canAccess()) {
                $forwardTargetPredicate = $section->getForwardingTargetPredicate();
                if (!empty($forwardTargetPredicate) && $forwardTargetPredicate->canForward())
                {
                    $forwardTarget = $forwardTargetPredicate->getForwardingTarget();
                    $controller->forward(
                        $forwardTarget['action'],
                        OX_Common_ArrayUtils::getDefault($forwardTarget, 'controller'), 
                        OX_Common_ArrayUtils::getDefault($forwardTarget, 'module'), 
                        OX_Common_ArrayUtils::getDefault($forwardTarget, 'params', array()));
                }
                else {
                    OX_Common_Log::info('Access denied for page: ' . $request->getModuleName() . '/' . $request->getControllerName() . '/' . $request->getActionName());
                    $controller->forward('access-denied', 'error', 'default');
                }
            }
        }
    }
}