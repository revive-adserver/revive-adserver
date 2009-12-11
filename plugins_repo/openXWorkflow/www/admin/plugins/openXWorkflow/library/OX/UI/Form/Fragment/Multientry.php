<?php

/**
 * Manages entry of multiple entries of the same type. An entry can be e.g. variable 
 * set/delete operation with a combo box for operation type choice and an input box
 * for variable name.
 * 
 * Please see OX_UI_Form_Fragment_Multientry_Entry for the base class for a fragment
 * representing an individual entry.
 */
abstract class OX_UI_Form_Fragment_Multientry extends OX_UI_Form_Fragment_Default
{
    private $id;
    private $displayGroupLegend;
    private $moreEntriesLinkText = 'Add more entries';
    private $moreEntriesLinkIcon = null;
    private $noEntriesText = 'No entries';
    private $emptyEntriesToShow = 0;
    private $emptyEntriesToAdd = 1;
    
    private $form;
    private $values;
    
    private $entryFragments = array();
    
    public function __construct(array $options = array()) 
    {
        OX_Common_ObjectUtils::setOptions($this, $options);
    }
    
    
    /**
     * Creates an array of entry fragments created for the existing data to be edited.
     * Each fragment should correspond and be populated based on an existing data point.
     * 
     * @return array OX_UI_Form_Fragment_Multientry_Entry
     */
    public abstract function createPopulatedEntryFragments(array $values);
    
    
    /**
     * Crates an empty entry fragment.
     * 
     * @return OX_UI_Form_Fragment_Multientry_Entry
     */
    public abstract function createEmptyEntryFragment(array $values);

    
    /**
     * Called before populateEntry() is called on each entry.
     *
     * @param OX_UI_Form $form
     */
    public function beforeEntriesPopulate(OX_UI_Form $form)
    {
    }
    
    
    public final function build(OX_UI_Form $form, array $values)
    {
        $this->form = $form;
        $this->values = $values;
        
        // Add a hidden field that will let us detect that
        // this editor has been submitted
        $form->addElement('hidden', $this->name('submitted'), array('value' => true));
        
        // Add a dummy fragment that will call beforeEntriesPopulate() before
        // calling populate() on entries.
        $form->addFormFragment(new MultientryBeforePopulateFragment($this));
        
        // Add empty entry set information
        $noEntriesLineName = $this->name('noEntriesLine');
        $form->addElementWithLine('content', $this->name('noEntries'), 
            $noEntriesLineName, array('content' => $this->noEntriesText), array(
                'class' => 'hide', 'id' => $noEntriesLineName));
        $form->addDisplayGroup(array($noEntriesLineName), $this->name('displayGroup'));
        
        // Add template entry
        $templateFragment = $this->createEmptyEntryFragment($values);
        $templateFragment->setTemplate(true);
        $this->setUpAndAddFragment($templateFragment, 'template');
        
    	// Check if we're handling submission of the editor. If not, we'll
    	// create entries based on the model. If so, we'll need to build the form
    	// based on the submitted values. We need to do that because entries can be
    	// added and removed on the client side.
    	$fragmentIndex = 0;
    	if (isset($values[$this->name('submitted')])) {
        	// Add fragments based on the request. We'll be adding empty entries
        	// which will get populated later on when the whole form is populated.
    	    $prefix = $this->id . '_';
    	    $prefixLen = strlen($prefix);
    	    $entryIndices = array();
    	    foreach ($values as $key => $value) {
    	    	if (OX_Common_StringUtils::startsWith($key, $prefix)) {
    	    	    $split = split('_', substr($key, $prefixLen));
    	    	    $index = $split[0];
    	    	    if (preg_match("/\\d+/", $index)) {
    	    	        $entryIndices[$index] = true;
    	    	    }
    	    	}
    	    }
    	    
    	    foreach ($entryIndices as $entryIndex => $value) {
                $fragment = $this->createEmptyEntryFragment($values);
                if ($this->setUpAndAddFragment($fragment, $entryIndex, true)) {
                    $fragmentIndex = max($fragmentIndex, $entryIndex) + 1;
                }
    	    }
    	} else {
        	// Add fragments from the existing data
            $fragments = $this->createPopulatedEntryFragments($values);
            foreach ($fragments as $fragment) {
                $this->setUpAndAddFragment($fragment, $fragmentIndex++);
            }
    	}

    	// Add the requested number of always blank entries
        for ($i = 0; $i < $this->emptyEntriesToShow; $i++) {
            $fragment = $this->createEmptyEntryFragment($values);
            $this->setUpAndAddFragment($fragment, $fragmentIndex++);
        }
    	
        // Hide no entries message if we have entry editors
        if ($fragmentIndex == 0) {
            OX_UI_Form_Element_Utils::removeClassInElementOptions($form->getElement($noEntriesLineName), 'hide');
        }
    	
        // Add more entries link
        $moreEntriesLinkName = $this->name('moreEntries');
        $moreEntriesLinkLineName = $moreEntriesLinkName . 'Line';
        $form->addElementWithLine('link', $moreEntriesLinkName, $moreEntriesLinkLineName, array (
                'text' => $this->moreEntriesLinkText, 
                'href' => '#', 
                'class' => (!empty($this->moreEntriesLinkIcon) ? 'inlineIcon icon' . $this->moreEntriesLinkIcon : ''), 
                'id' => $moreEntriesLinkName), array('class' => 'compact'));
        $form->addDisplayGroup(array($moreEntriesLinkLineName), $this->name('displayGroup'), 
            array('legend' => $this->displayGroupLegend,
              'id' => $this->name()));
            
        // Add JavaScript handlers
        $options = 'numberOfEntriesToAdd: ' . $this->emptyEntriesToAdd;
        OX_UI_View_Helper_InlineScriptOnce::inline('$("#' . $this->name() . 
            '").formMultientries({' . $options . '});');
    }

    
    /**
     * Sets the required properties on the provided entry fragment and adds it to 
     * the form.
     *
     * @return true if the fragment has been added
     */
    private function setUpAndAddFragment(OX_UI_Form_Fragment_Multientry_Entry $fragment, 
        $name, $skipIfBlank = false)
    {
        $fragment->setElementNamePrefix($this->name($name));
        $fragment->setDisplayGroupName($this->name('displayGroup'));
        
        if (!$skipIfBlank || !$fragment->isBlank($this->values)) {
            $this->form->addFormFragment($fragment);
            $this->entryFragments []= $fragment;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns an array of OX_UI_Form_Fragment_Multientry_Entry instances created to 
     * handle the current request. This array will be useful when the multientry
     * controller needs to validate some cross-entry properties. In this case, it would
     * be easiest to expose some form data access methods in the entry and retrieve
     * this data from the fragments on validation.
     * 
     * @return array of OX_UI_Form_Fragment_Multientry_Entry
     */
    protected function getEntryFragments()
    {
        return $this->entryFragments;
    }
    
    
    /**
     * Generates a name prefixed by this multientry's id.
     */
    private function name($name = '')
    {
        if (strlen($name) == 0) {
            return $this->id;
        } else {
            return $this->id . '_' . $name;
        }
    }
    
    
    /**
     * Sets an identifier for this multientry fragment. If more than one multientry
     * fragments are used on the same form, they must have different identifiers.
     */    
    public function setId($id)
    {    
        $this->id = $id;
    }

    
    /**
     * Sets the legend of the display group that will be created for this multientry
     * fragment.
     */
    public function setDisplayGroupLegend($displayGroupLegend)
    {
        $this->displayGroupLegend = $displayGroupLegend;
    }

    
    /**
     * Sets icon identifier for the more entries link.
     */
    public function setMoreEntriesLinkIcon($moreEntriesLinkIcon)
    {
        $this->moreEntriesLinkIcon = $moreEntriesLinkIcon;
    }

    
    /**
     * Sets text for the more entries link.
     */
    public function setMoreEntriesLinkText($moreEntriesLinkText)
    {
        $this->moreEntriesLinkText = $moreEntriesLinkText;
    }

    
    /**
     * Sets text to display when there are no entries on the list.
     * Note the text will not display if setEmptyEntriesToShow() was set
     * to a number larger than 0.
     */
    public function setNoEntriesText($noEntriesText)
    {
        $this->noEntriesText = $noEntriesText;
    }

    
    /**
     * Sets the number of empty entries that will always display at the bottom.
     * If the number is greater than zero, text set using setNoEntriesText() will
     * not display.
     */
    public function setEmptyEntriesToShow($number)
    {
        if (!is_numeric($number) || $number < 0) {
            throw new Exception('emptyEntriesToShow must be a number greater or equal to 0');
        }
        
        $this->emptyEntriesToShow = $number;
    }

    
    /**
     * Sets the number of empty entries that will be added when the user clicks the
     * "Add more entries" link.
     */
    public function setEmptyEntriesToAdd($number)
    {
        if (!is_numeric($number) || $number < 1) {
            throw new Exception('emptyEntriesToAdd must be a number greater or equal to 1');
        }
        
        $this->emptyEntriesToAdd = $number;
    }
}

/**
 * A dummy fragment we use to invoke beforeEntriesPopulate() on 
 * OX_UI_Form_Fragment_Multientry before entries' populate() method are invoked. 
 */
class MultientryBeforePopulateFragment extends OX_UI_Form_Fragment_Default
{
    /**
     * @var OX_UI_Form_Fragment_Multientry
     */
    private $multientry;
    
    
    public function __construct(OX_UI_Form_Fragment_Multientry $multientry)
    {
        $this->multientry = $multientry;
    }

    
    public function populate(OX_UI_Form $form)
    {
        $this->multientry->beforeEntriesPopulate($form);
    }
}