<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH.'/lib/pear/HTML/QuickForm/Renderer/Array.php';

/**
 * A custom form renderer for OA form.
 *
 */
class OA_Admin_UI_Component_ArrayRenderer
    extends HTML_QuickForm_Renderer_Array
{
    private $_groupStack;
    /**
     * @var OA_Admin_UI_Component_Form
     */
    private $_form;


    function OA_Admin_UI_Component_ArrayRenderer($collectHidden = false, $staticLabels = false)
    {
        parent::HTML_QuickForm_Renderer_Array($collectHidden, $staticLabels);
        $this->_groupStack = array();
    }

    /**
     * @param OA_Admin_UI_Component_Form $form
     */
    function startForm(&$form)
    {
        parent::startForm($form);
        $this->_ary['id'] = $form->getId();
        $this->_ary['hasRequiredFields'] = $form->hasRequiredFields();
        $this->_ary['JQueryMethods'] = $form->getJQueryValidationMethods();
        $this->_ary['JQueryRules'] = $form->getJQueryValidationRules();

        $this->_form = $form;
    }


    function startGroup(&$group, $required, $error)
    {
        //store the currentGroup array if we're going deeper into another group
        if ($this->_currentGroup != null) {
            array_push($this->_groupStack, $this->_currentGroup);
        }

        $this->_currentGroup = $this->_elementToArray($group, $required, $error);
        if (!empty($error)) {
            $this->_ary['errors'][$this->_currentGroup['name']] = $error;
        }
    } // end func startGroup


    function finishGroup(&$group)
    {
        //save current group array
        $groupArr = $this->_currentGroup;

        //restore last group from stack (if any), pop will return null if stack empty
        $this->_currentGroup = array_pop($this->_groupStack);

        //now store this group in its parent
        $this->_storeArray($groupArr);

    } // end func finishGroup



   /**
    * Overrides method from parent. Allows group to be an element in other group.
    * Stores an array representation of an element in the form array
    *
    * @param array  Array representation of an element
    * @return void
    */
    function _storeArray($elAry)
    {
        // where should we put this element...
        if (is_array($this->_currentGroup)) {
            $this->_currentGroup['elements'][] = $elAry;
        } elseif (isset($this->_currentSection)) {
            $this->_ary['sections'][$this->_currentSection]['elements'][] = $elAry;
        } else {
            $this->_ary['elements'][] = $elAry;
        }
    }


    /**
     * Overrides method from parent class. Apart from standard header properties
     * logs header type as well and supports icon and decorators.
     */
    public function renderHeader(&$header)
    {
        $ret = array(
            'header' => $header->toHtml(),
            'name'   => $header->getName(),
            'type'   => $header->getType(),
        );

        //add header icon if any
        $headerIcon =  $header->getAttribute("icon");
        if (!empty($headerIcon)) {
             $ret['icon'] = $headerIcon;
        }

        //get decorators
        $decoratorsArr = $this->decoratorsToArray($header->getName());
        if ($decoratorsArr) {
            $ret['decorators']= $decoratorsArr;
        }


        //store group array
        $this->_ary['sections'][$this->_sectionCount] = $ret;

        $this->_currentSection = $this->_sectionCount++;
    }


    /**
     * Renders raw HTML element
     */
    public function renderHtml(&$html)
    {
        $elAry = array(
            'name'     => $html->getName(),
            'type'     => $html->getType(),
            'html'     => $html->toHtml()
        );

        //get decorators
        $decoratorsArr = $this->decoratorsToArray($html->getName());
        if ($decoratorsArr) {
            $elAry['decorators']= $decoratorsArr;
        }

        $this->_storeArray($elAry);
    }



    /**
     * Overrides method from parent class. Adds support for custom and plugin-custom
     * element types.
     *
     * @param  HTML_QuickForm_element    element being processed
     * @param  bool                      Whether an element is required
     * @param  string                    Error associated with the element
     * @return array representing an element
     */
    function _elementToArray(&$element, $required, $error)
    {
        $ret = parent::_elementToArray($element, $required, $error);

        //add id if any
        $elemId = $element->getAttribute('id');
        if (!empty($elemId)) {
            $ret['id'] = $elemId;
        }
        $type = $ret['type'];
        //add options from select
        if('select' == $type) {
            $ret['selected'] = is_array($this->_values)? array_map('strval', $this->_values): array();
            foreach ($element->_options as $option) {
                $options[$option['attr']['value']] = $option['text'];
            }
            $ret['options'] =  $options;
        }

        //add vars to array for custom
        if('custom' == $type || 'plugin-custom' == $type
            || 'script' == $type || 'plugin-script' == $type) {
            $ret['vars'] = $element->getVars();
            $ret['templateId'] = $element->getTemplateId();
        }
        if('custom' == $type || 'plugin-custom' == $type) {
            $ret['break'] = $element->isVisible();
        }
        if('plugin-custom' == $type || 'plugin-script' == $type) {
            $ret['plugin'] = $element->getPluginName();
        }

        //decorators
        $decoratorsArr = $this->decoratorsToArray($element->getName());
        if ($decoratorsArr) {
            $ret['decorators']= $decoratorsArr;
        }

        //add suport for label-placement
        $ret = $this->setCustomAttribute('labelPlacement', $element, $ret);
        $ret = $this->setCustomAttribute('prefix', $element, $ret);
        $ret = $this->setCustomAttribute('suffix', $element, $ret);


        //store all attributes so we can use them to generate html
        $ret['attributes'] = $element->getAttributes();

        return $ret;
    }


    private function setCustomAttribute($attributeName, $element, $ret)
    {
        $attrValue = $element->getAttribute($attributeName);
        if (!empty($attrValue)) {
            $ret[$attributeName] = $attrValue;
            $element->removeAttribute($attributeName);
        }

        return $ret;
    }


    private function decoratorsToArray($elementName)
    {
        $elDecorators = $this->_form->getDecorators($elementName);
        if (empty($elDecorators)) {
            return null;
        }
        foreach ($elDecorators as $decorator) {
            $elPrepend .= $decorator->prepend();
            $elAppend = $decorator->append().$elAppend;
        }

        $result['prepend'] = $elPrepend;
        $result['append'] = $elAppend;
        $result['list'] = $elDecorators;

        return $result;
    }
}
?>
