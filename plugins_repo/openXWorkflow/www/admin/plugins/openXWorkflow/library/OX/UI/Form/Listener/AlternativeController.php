<?php

/**
 * A form listener that binds an OX_UI_Form_Fragment_AlternativeDriver with the 
 * relevant OX_UI_Form_Fragment_Alternative fragments.
 */
class OX_UI_Form_Listener_AlternativeController extends OX_UI_Form_Listener_Default
{
    /**
     * Indicates that this listener has already been added to the form and hence all
     * attempts to register further drivers should fail.
     */
    private $committed = false;

    /**
     * Indexed by [alternativeHash][driverElementId][driverElementValue].
     */
    private $drivingValuesByAlternativeHash = array();
    
    /**
     * Maps OX_UI_Form_Fragment_Alternative instance hashes to the actual instances.
     */
    private $alternativesByAlternativeHash = array();
    
    private $drivers = array();
    
    /**
     * Creates the controller. Calls addDriver() using the provided parameters.
     */ 
    public function __construct($driver = null, array $alternatives = null)
    {
        if ($driver && $alternatives) { 
            $this->addDriver($driver, $alternatives);
        }
    }

    /**
     * @param $driver. Must be either OX_UI_Form_Fragment_AlternativeDriver or
     *         Zend_Form_Element instance.
     * @param array $alternatives. An array mapping values returned by the driver element
     *         to the array of fragments that should be displayed for given values of the driver
     *         element. Not all values assumed by the driver must appear in this array.
     *         If there is no mapping for some driver value in this array, no fragments
     *         will be visible for that value.
     */    
    public function addDriver($driver, $alternatives)
    {
        if ($this->committed) {
            throw new Exception('The drivers can be added only before this controller is added to an OX_UI_Form.');
        }
        
        if (!isset($driver)) {
            throw new Exception('$driver must not be null');
        }
        
        if (!($driver instanceof OX_UI_Form_Fragment_AlternativeDriver) && 
            !($driver instanceof Zend_Form_Element)) {
            throw new Exception('$driver must be either an instance of Zend_Form_Element or OX_UI_Form_Fragment_AlternativeDriver');
        }
        
        $this->drivers []= array($driver, $alternatives);
    }

    
    private function addDriversInternal(OX_UI_Form $form)
    {
        // Prevent adding drivers at this point.
        $this->committed = true;
        
        foreach ($this->drivers as $spec) {
            $driver = $spec[0];
            $alternatives = $spec[1];

            $driverElement = null;
            if ($driver instanceof OX_UI_Form_Fragment_AlternativeDriver) {
                $driverElement = $driver->getDriverElement($form);
            } else {
                $driverElement = $driver;
            }
            
            foreach ($alternatives as $value => $alternatives) {
                $alternatives = self::wrapWithArray($alternatives);
                foreach ($alternatives as $alternative) {
                    $alternativeHash = spl_object_hash($alternative);
                    $this->alternativesByAlternativeHash[$alternativeHash] = $alternative;
                    $this->drivingValuesByAlternativeHash[$alternativeHash][$this->getOrCreateId($driverElement)][$value] = true;
                }
            }
        }
    }
    
    
    private static function wrapWithArray($objectOrArray)
    {
        if (is_array($objectOrArray)) {
            return $objectOrArray; 
        } else {
            return array($objectOrArray);
        }
    }
    
    
    public function afterListenerAdded(OX_UI_Form $form)
    {
        $this->addDriversInternal($form);
        $values = Zend_Controller_Front::getInstance()->getRequest()->getParams();
        
        // For each fragment, determine whether it should be enabled or disabled.
        foreach ($this->alternativesByAlternativeHash as $alternativeHash => $alternative) {
        	$driverIds = $this->drivingValuesByAlternativeHash[$alternativeHash];
        	$enabled = true;
        	foreach ($driverIds as $elementId => $value) {
        	    // The condition below implicitly assumes that the alternatives over
        	    // which we're iterating are topologically sorted. Currently, we don't
        	    // do sorting here and assume the drivers are registered in the right 
        	    // (topological) order. For example if alternative A drives B and B
        	    // drives C, the driver registration order should be A, B, C.
        	    // In other words, below we're assuming that the visibility of a driver
        	    // is determined before the driver determines visibility of some other
        	    // alternative.
        	    if (OX_UI_Form_Element_Utils::isVisible($form->getElement($elementId))) {
            	    $formValue = OX_Common_ArrayUtils::getDefault($values, $elementId, $form->getValue($elementId));
            	    $enabled = $enabled && isset($this->drivingValuesByAlternativeHash[$alternativeHash][$elementId][$formValue]);
        	    }
        	}
        	$alternative->setEnabled($form, $enabled);
        }

        OX_UI_View_Helper_InlineScriptOnce::inline('$.formAlternativeDriver(' . $this->generateJavascriptSpec($form) . ');');
    }
    
    
    private function generateJavascriptSpec(OX_UI_Form $form)
    {
        $spec = array();
        foreach ($this->alternativesByAlternativeHash as $alternativeHash => $alternative) {
            $controlledElementIds = self::getControlledElementIds($form, $alternative);
            $driverIds = $this->drivingValuesByAlternativeHash[$alternativeHash];
            foreach ($driverIds as $driverElementId => $values) {
                foreach ($controlledElementIds as $controlledElementId) {
                    foreach ($values as $value => $ignored) {
                        $spec['#' . $controlledElementId][$driverElementId][$value] = true;
                    }
                }
            }
        }
        return json_encode($spec);
    }
    
    
    
    private static function getControlledElementIds(OX_UI_Form $form, 
        OX_UI_Form_Fragment_Alternative $alternative)
    {
        $ids = array();
        
        $displayGroupNames = $alternative->getControlledDisplayGroupNames();
        if (isset($displayGroupNames)) {
            foreach ($displayGroupNames as $displayGroupName) {
                $displayGroup = $form->getDisplayGroup($displayGroupName);
                $ids []= self::getOrCreateId($displayGroup);
            }
        }
        
        $elementNames = $alternative->getControlledElementNames();
        if (isset($elementNames)) {
            foreach ($elementNames as $elementName) {
                $element = $form->getElement($elementName);
                $ids []= self::getOrCreateId($element);
            }
        }
        
        $alternatives = $alternative->getControlledAlternatives();
        if (isset($alternatives)) {
            foreach ($alternatives as $fragment) {
                $ids = array_merge($ids, self::getControlledElementIds($form, $fragment));
            }
        }
        
        return $ids;
    }
    
    
    private static function getOrCreateId($element)
    {
        $id = $element->getAttrib('id');
        if (empty($id))
        {
            $id = $element->getId();
            $element->setAttrib('id', $id);
        }
        return $id;
    }
}
