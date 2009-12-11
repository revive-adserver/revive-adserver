<?php

/**
 * A section in page navigation. Work in progress, subject to large changes.
 */
class OX_UI_Menu_Section
{
    /**
     * In order for the section to be accessible, all predicates (if defined) up 
     * to the parent node must evaluate to true. 
     */
    const EVALUATION_WITH_PARENT = 1;
    
    /** 
     * In order for the section to be accessible, its enough that the section's
     * predicate evaluates to true. Parent section's predicates will not be
     * taken into account in this mode.
     */
    const EVALUATION_EXCLUSIVE = 2;
    
    /** Unique identifier of this section */
    private $id;
    
    /** Label */
    private $label;
    
    /** Identifier of the icon for this section */
    private $icon = null;
    
    /** 
     * If true, an attempt to view the screen corresponding to this section by a non-logged-in
     * user will redirect to the login screen. 
     */
    private $loginRequired = true;
    
    /**
     * An instance of OX_Common_Predicate that will decide whether this section is accessible
     * to the user and whether it should appear in the navigation displayed for the user.
     * For a child section to be accessible, all its parents up to the root node
     * must also be accessible. This kind of behaviour makes it easy to disable large
     * parts of the UI (e.g. main tabs) with one predicate applied on the high-level
     * entries of the menu structure.
     * 
     * Additionally, if the predicate implements OX_UI_Controller_ForwardingTarget,
     * in case of no access, the request will be forwarded to the specified target.
     * Note that forwarding cycle detection is not performed.
     *
     * @var OX_Common_Predicate
     */
    private $predicate = null;
    
    /**
     * Determines the exact strategy for evaluating predicates of sections, e.g.
     * in relation to their parents. See EVALUATION_* constants for more information.
     */
    private $predicateEvaluation = null;
    
    /**
     * Names of parameters to copy from the current request.
     */
    private $parameterNames = array ();
    
    /** Level of this section, navigation schema specific! */
    private $level = -1;
    
    const LEVEL_ROOT = 0;
    const LEVEL_TAB_MAIN = 1;
    const LEVEL_LEFT_MAIN = 2;
    const LEVEL_LEFT_SUB = 3;
    const LEVEL_TAB_CONTENT = 4;
    const LEVEL_CONTENT = 5;
    
    const DEFAULT_LABEL = 'Untitled';
    const DEFAULT_ICON = 'Adnetwork';
    
    /** Child sections of this section */
    protected $aChildSections = array ();
    
    /** 
     * Parent section of this section, duplication with aChildSections for the sake 
     * of performance. 
     *
     * @var OX_UI_Menu_Section
     */
    private $parent = NULL;


    public function __construct($id, $level, $label = null, array $options = null)
    {
        $this->id = $id;
        $this->level = $level;
        $this->label = $label ? $label : self::DEFAULT_LABEL;
        $this->predicateEvaluation = self::EVALUATION_WITH_PARENT;
        
        OX_Common_ObjectUtils::setOptions($this, $options);
    }


    public function getLabel()
    {
        return $this->label;
    }


    public function getIcon()
    {
        return $this->icon;
    }


    public function setIcon($icon)
    {
        $this->icon = $icon;
    }


    public function isLoginRequired()
    {
        return $this->loginRequired;
    }


    public function setPredicate(OX_Common_Predicate $predicate = null)
    {
        $this->predicate = $predicate;
    }


    public function setPredicateEvaluation($evaluation)
    {
        $this->predicateEvaluation = $evaluation;
    }


    public function setLoginRequired($loginRequired = true)
    {
        return $this->loginRequired = $loginRequired;
    }


    public function setParameterNames(array $parameterNames = array())
    {
        $this->parameterNames = $parameterNames;
    }


    public function append(OX_UI_Menu_Section $section)
    {
        $this->aChildSections[] = $section;
        $section->parent = $this;
    }


    /**
     * @return OX_UI_Menu_Section
     */
    public function parentOrSelf($level)
    {
        if ($this->level == $level) {
            return $this;
        }
        else {
            if ($this->parent) {
                return $this->parent->parentOrSelf($level);
            }
            else {
                return null;
            }
        }
    }


    public function children($level)
    {
        $children = $this->aChildSections;
        $result = array ();
        foreach ($children as $child) {
            if ($child->level == $level) {
                if ($child->predicate && !$child->predicate->evaluate()) {
                    continue;
                }
                $result[] = $child;
            }
        }
        
        return $result;
    }


    public function siblings($level)
    {
        $parent = $this->parent;
        if ($parent) {
            return $parent->children($level);
        }
        else {
            return null;
        }
    }


    /**
     * @return true if the predicates on this section and all ancestor sections allow 
     * access to it.
     */
    public function canAccess()
    {
        $current = ($this->predicate && $this->predicate->evaluate()) || !$this->predicate;
        $parent = $this->predicateEvaluation == self::EVALUATION_EXCLUSIVE || 
            (($this->parent && $this->parent->canAccess()) || !$this->parent);
        return $current && $parent;
    }

    
    public function getForwardingTargetPredicate()
    {
        if ($this->predicate instanceof OX_UI_Controller_ForwardingTarget) {
            $target = $this->predicate->getForwardingTarget();
            if (!empty($target))
            {
                return $this->predicate;
            }
        }
        
        if (isset($this->parent)) {
            return $this->parent->getForwardingTargetPredicate();
        }
        
        return null;
    }

    
    public function getForwardingTarget()
    {
        $predicate = $this->getForwardingTargetPredicate();
        return $predicate ? $predicate->getForwardingTarget() : null;
    }

    
    public function getId()
    {
        return $this->id;
    }


    public function getAction($default = "index")
    {
        return $this->getSegment(2, $default);
    }


    public function getController($default = "index")
    {
        return $this->getSegment(1, $default);
    }


    public function getModule($default = "index")
    {
        return $this->getSegment(0, $default);
    }


    public function getSegment($index, $default = "index")
    {
        $segments = split("/", $this->id);
        if (count($segments) < $index + 1) {
            return $default;
        }
        else {
            return $segments[$index];
        }
    }


    public function hasLevel($level)
    {
        $parent = $this->parentOrSelf($level);
        return $parent ? count($parent->siblings($level)) : false;
    }


    public function hasLevelLeftMain()
    {
        return $this->hasLevel(self::LEVEL_LEFT_MAIN);
    }


    public function hasLevelTabContent()
    {
        return $this->hasLevel(self::LEVEL_TAB_CONTENT);
    }


    public function buildModel($menuLevel)
    {
        $section = $this;
        
        $parent = $section->parentOrSelf($menuLevel);
        if ($parent == null) {
            return null;
        }
        
        $siblings = $parent->siblings($menuLevel);
        
        $mainTabsModel = array ();
        $siblingsCount = count($siblings);
        for ($i = 0; $i < $siblingsCount; $i++) {
            $siblingSection = $siblings[$i];
            $active = $siblings[$i] === $parent;
            $beforeActive = ($i + 1 < $siblingsCount) && ($siblings[$i + 1] === $parent);
            $afterActive = ($i - 1 >= 0) && ($siblings[$i - 1] === $parent);
            
            // We don't start with an empty array here to avoid trailing slashes in 
            // URLs when there are no extra params and the array is empty.
            $params = null;
            $request = Zend_Controller_Front::getInstance()->getRequest();
            if ($request && count($siblingSection->parameterNames) > 0) {
                $params = array ();
                foreach ($siblingSection->parameterNames as $paramName) {
                    $value = $request->getParam($paramName);
                    if ($value) {
                        $params[$paramName] = $value;
                    }
                }
            }
            
            $mainTabsModel[] = array (
                    "first" => $i == 0, 
                    "last" => $i == $siblingsCount - 1, 
                    "active" => $active, 
                    "beforeActive" => $beforeActive, 
                    "afterActive" => $afterActive, 
                    "action" => $siblingSection->getAction(), 
                    "controller" => $siblingSection->getController(), 
                    "module" => $siblingSection->getModule(), 
                    "params" => $params, 
                    "section" => $siblingSection);
        }
        
        return $mainTabsModel;
    }
}
