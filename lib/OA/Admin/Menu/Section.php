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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionAccountChecker.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionCheckerFilter.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionPermissionChecker.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionTypeFilter.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/CompoundChecker.php');
require_once(LIB_PATH . '/Translation.php');


/**
 * Menu section element
 *
 */
class OA_Admin_Menu_Section
{
    public const TYPE_ROOT = 0;
    public const TYPE_TAB_MAIN = 1;
    public const TYPE_LEFT_MAIN = 2;
    public const TYPE_LEFT_SUB = 3;
    public const TYPE_TAB_CONTENT = 4;
    public const TYPE_CONTENT = 5;

    public $id; //eg campaign-edit
    public $nameKey; //Translation key without 'str'
    public $link; //link to script with params
    public $helpLink; //link to help page
    public $rank; //float value used to resove conflicts between the sections, defaults to 1
    public $exclusive; //bolean value stating whether section should be shown exclusively (no sibling sections) when it's active //TODO change to type
    public $affixed; //bolean value stating whether section should be shown affixed to sibling sections only when it's active //TODO change to type
    public $aSections; //list of subsections
    public $oSectionChecker; //checker used to decide whether this section can be shown to the user
    public $parentSection; //reference to parent section
    public $aSectionsMap; //hash holding id => section

    /**
     * When replacing some information for a section, it can happen that you also replace the "link"
     * which means that a given menu section will link to a different page.
     * However, this old page can still be linked from other places in OpenX. Only the Menu knows about the fact that the link has changed.
     * For links still pointing to the old page name, the menu code will detect that the user is accessing the old page, and will
     * redirect the user to the new page.
     *
     * @see OA_Admin_UI::redirectSectionToCorrectUrlIfOldUrlDetected()
     * @var bool
     */
    public $sectionHasBeenReplaced;

    /**
     * A string name that indicates relationship between sections on
     * the same level - if a couple of sections share the same group name they could
     * eg. be displayed with separator added after to separate from other sections
     * @var string
     */
    public $groupName;

    /**
     * Indicates section type. Whether it is eg. main tab or left menu or content tab
     *
     * @var int
     */
    public $type = -1;


    /**
     * OXP translation class
     *
     * @var OX_Translation
     */
    public $oTranslation;


    /**
     * Constructs a menu section.
     *
     * Accounts permisions is an array of accountsPermisions tuples, see constructor description for more details
     *   AccountsPermisions tuple can be:
     *   1) a single element then it should be an account eg OA_ADMIN_ACCOUNT
     *   2) an 2 element array key => value
     *       - KEY stores account(s) and can be:
     *           * a single account element eg OA_ADMIN_ACCOUNT
     *           * an array of accounts eg. array(OA_ADMIN_ACCOUNT, OA_MANAGER_ACCOUNT)
     *       - VALUE stores permissions(s) and can be:
     *           * a single permission element eg OA_OA_PERM_ZONE_INVOCATION
     *           * an array of permissions eg. array(OA_PERM_ZONE_INVOCATION, OA_PERM_SUPER_ACCOUNT)
     *   If KEY is an array it is assumed that every account from that array should be associated with VALUE permissions     *
     *
     * @param string $id eg campaign-edit
     * @param string $name eg campaign-edit
     * @param string $link link to script with params
     * @param boolean $exclusive whether section should be shown exclusively (no sibling sections) when it's active
     * @param string $helpLink link to help page
     * @param array $aAccountPermissions an array of accountsPermisions tuples, see constructor description for more details
     * @param float $rank float value used to resove conflicts between the sections, defaults to 1
     * @param boolean $affixed whether section should be shown affixed to sibling sections only when it's active
     * @return OA_Admin_Menu_Section
     */
    public function __construct($id, $nameKey, $link, $exclusive = false, $helpLink = null, $aAccountPermissions = [], $rank = 1, $affixed = false, $groupName = null)
    {
        $this->id = $id;
        $this->setNameKey($nameKey);
        // Debug: uncomment below if you are looking for a given Section ID in
        // order to add a new menu entry using the menu XML definition
        // $this->setNameKey($id. " ".$nameKey);
        $this->setLink($link);
        $this->setHelpLink($helpLink);
        $this->setExclusive($exclusive);
        $this->rank = $rank;
        $this->affixed = $affixed;
        $this->aSections = [];
        $this->oSectionChecker = empty($aAccountPermissions) ? null : $this->_createSecurityChecker($aAccountPermissions);
        $this->aSectionsMap = [];
        $this->groupName = $groupName;
        // Create instance of OX_Translation
        $this->oTranslation = new OX_Translation();
        $this->sectionHasBeenReplaced = false;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setExclusive($exclusive)
    {
        $this->exclusive = $exclusive;
    }


    public function setHelpLink($helpLink)
    {
        $this->helpLink = $helpLink;
    }


    public function setNameKey($nameKey)
    {
        $this->nameKey = $nameKey;
    }


    public function setLink($link)
    {
        $this->link = $link;
    }


    public function setSectionHasBeenReplaced()
    {
        $this->sectionHasBeenReplaced = true;
    }


    public function hasSectionBeenReplaced()
    {
        return $this->sectionHasBeenReplaced;
    }


    /**
     * Returns a translated name of this section
     *
     * @return unknown
     */
    public function getName()
    {
        return $this->oTranslation->translate($this->nameKey);
    }


    public function getLink($aParams = [])
    {
        return $this->setLinkParams($aParams);
    }


    public function setLinkParams($aParams)
    {
        if (strpos($this->link, '?')) {
            foreach ($aParams as $arg => $val) {
                $this->link = str_replace('{' . $arg . '}', $val, $this->link);
            }
        }
        return $this->link;
    }


    public function getHelpLink()
    {
        return $this->helpLink;
    }


    public function getRank()
    {
        return $this->rank;
    }


    public function isExclusive()
    {
        return $this->exclusive;
    }


    public function isAffixed()
    {
        return $this->affixed;
    }


    /**
     * Returns the groupName of this section (if any). Group name is used to
     * express relation between sections on the same level eg. a 10 sections on the same level
     * could be split intto three "groups" using group names. This information
     * would be used by UI to eg. display separator between the groups.
     * @return string group name or null if none
     */
    public function getGroupName()
    {
        return $this->groupName;
    }


    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }


    /**
     * @return int section type
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @return int section type
     */
    public function setType($type)
    {
        return $this->type = $type;
    }


    /**
     * Returns a child with a given id. If user have no access to this section
     * or if the child does not exists null is returned
     *
     * @param string $sectionId
     * @return OA_Admin_Menu_Section
     */
    public function &get($sectionId, $checkAccess = true)
    {
        if (!isset($this->aSectionsMap[$sectionId])) {
            $errMsg = "MenuSection::get() Cannot get section. No such section with id '" . $sectionId . "'";
            OA::debug($errMsg, PEAR_LOG_WARNING);
            return null;
        }

        $oChildSection = &$this->aSectionsMap[$sectionId];

        if ($checkAccess && !$oChildSection->check()) {
            $oChildSection = null;
        }

        return $oChildSection;
    }


    /**
     * Gets a list of child sections. Check access indicates whether section should
     * be filtered. If type is given only children of a given type are considered.
     * @param boolean $checkAccess indicates whether checks should permormed before letting user access sections
     */
    public function getSections($checkAccess = true, $type = null)
    {
        $aSections = &$this->aSections;

        if ($checkAccess) {
            $aFilteredSections = [];
            foreach ($aSections as $oSection) {
                if ($oSection->check()
                && ($type == null || $type == $oSection->getType())) {
                    $aFilteredSections[] = $oSection;
                }
            }
            $aSections = $aFilteredSections;
        }

        return $aSections;
    }


    /**
     * Returns the parent section of this section
     *
     * @return OA_Admin_Menu_Section
     */
    public function &getParent()
    {
        return $this->parentSection;
    }


    /**
     * Returns parent section of a given type. If current section is of the given
     * type it will be returned. If there is no parent of a given type null is returned.
     *
     * @param int $type OA_Admin_Menu_Section type contant
     * @return matching section of null in none matched
     */
    public function &getParentOrSelf($type)
    {
        if ($this->type == $type) {
            return $this;
        } else {
            return $this->parentSection != null ? $this->parentSection->getParentOrSelf($type) : null;
        }
    }


    /**
     * Returns siblings of this section. If type is given, returns only siblings
     * with this type.
     *
     * @param int $type
     * @return array of OA_Admin_Menu_Section objects
     */
    public function getSiblings($type)
    {
        if ($this->parentSection == null) {
            return [];
        }
        return $this->parentSection->getSections(true, $type);
    }


    public function setParent(&$section)
    {
        $this->parentSection = &$section;
    }


    public function &getChecker()
    {
        return $this->oSectionChecker;
    }


    public function setChecker(&$oChecker)
    {
        $this->oSectionChecker = &$oChecker;
    }


    public function check()
    {
        if (empty($this->oSectionChecker)) {
            return true;
        }

        return $this->oSectionChecker->check($this);
    }


    //BUILDER FUNCTIONS - not secured
    /**
     * Appends new section to the list of subsections. If element cannot be
     * added (eg. this is attempt to add it for the second time error is returned.
     *
     */
    public function add(&$section)
    {
        // Check if added section is unique in menu
        if (isset($this->aSectionsMap[$section->getId()])) {
            $errMsg = "MenuSection::add() Cannot add section '" . $section->getId() . "': section with given id already exists";
            return MAX::raiseError($errMsg);
        }

        $this->aSections[] = &$section;
        $section->setParent($this);
        $this->_addToHash($section);

        return true;
    }


    /**
     * Inserts new section before the section with the specified id. If the section
     * with the specified id does not exists MAX::raiseError is returned.
     *
     * @param String $existingSectionId
     * @param OA_Admin_Menu_Section $newSection
     */
    public function insertBefore($existingSectionId, &$newSection)
    {
        // Check parent
        if (!isset($this->aSectionsMap[$existingSectionId])) {
            $errMsg = "MenuSection::insertBefore() Cannot insert section '" . $newSection->getId() . "' before a non existent menu section with id '" . $existingSectionId . "'";
            return MAX::raiseError($errMsg);
        }

        //check if added section is unique in menu
        if (isset($this->aSectionsMap[$newSection->getId()])) {
            $errMsg = "MenuSection::insertBefore() Cannot insert section '" . $newSection->getId() . "': section with given id already exists";
            return MAX::raiseError($errMsg);
        }

        $sectionIndex = $this->_getSectionIndex($existingSectionId, $this->aSections);
        array_insert($this->aSections, $sectionIndex, $newSection);
        $newSection->setParent($this);
        $this->_addToHash($newSection);

        return true;
    }


    /**
     * Inserts new section after the section with the specified id. If the section
     * with the specified id does not exists MAX::raiseError is returned.
     *
     * @param String $existingSectionId
     * @param OA_Admin_Menu_Section $newSection
     */
    public function insertAfter($existingSectionId, &$newSection)
    {
        if (!isset($this->aSectionsMap[$existingSectionId])) {
            $errMsg = "MenuSection::insertAfter() Cannot insert section '" . $newSection->getId() . "' after a non existent menu section with id '" . $existingSectionId . "'";
            return MAX::raiseError($errMsg);
        }

        //check if added section is unique in menu
        if (isset($this->aSectionsMap[$newSection->getId()])) {
            $errMsg = "MenuSection::insertAfter() Cannot insert section '" . $newSection->getId() . "': section with given id already exists";
            return MAX::raiseError($errMsg);
        }

        $sectionIndex = $this->_getSectionIndex($existingSectionId, $this->aSections);
        array_insert($this->aSections, $sectionIndex + 1, $newSection);
        $newSection->setParent($this);
        $this->_addToHash($newSection);

        return true;
    }


    /**
     * Gets index of a section with a given id in the list of this sections.
     */
    public function _getSectionIndex($key, &$sections)
    {
        //TODO simple search for now replace with some hashing?
        $arrLength = count($sections);
        for ($i = 0; $i < $arrLength; $i++) {
            if ($sections[$i]->getId() == $key) {
                return $i;
            }
        }
        return -1;
    }


    /**
     * Private
     *
     * @param unknown_type $section
     */
    public function _addToHash(&$section)
    {
        //add new section to flat array
        $this->aSectionsMap[$section->getId()] = &$section;
    }


    public function _createSecurityChecker($aAccountPermissionPairs)
    {
        $checkers = [];


        foreach ($aAccountPermissionPairs as $elem) {
            //$elem can be
            // 1) a single element then it should be an account eg OA_ADMIN_ACCOUNT
            // 2) an 2 element array key => value
            //    - KEY stores account(s) and can be:
            //        * a single account element eg OA_ADMIN_ACCOUNT
            //        * an array of accounts eg. array(OA_ADMIN_ACCOUNT, OA_MANAGER_ACCOUNT)
            //    - VALUE stores permissions(s) and can be:
            //        * a single permission element eg OA_OA_PERM_ZONE_INVOCATION
            //        * an array of permissions eg. array(OA_PERM_ZONE_INVOCATION, OA_PERM_SUPER_ACCOUNT)
            // If KEY is an array it is assumed that every account from that array should be associated with VALUE permissions

            if (is_array($elem)) { //(account,perm) pair

                $aPairAccounts = array_make(key($elem));
                $aPairPermissions = array_make(current($elem));

                foreach ($aPairAccounts as $i => $aPairAccount) {
                    $checkers[] = new OA_Admin_Menu_Compound_Checker(
                        [
                      new OA_Admin_SectionAccountChecker($aPairAccount),
                      new OA_Admin_SectionPermissionChecker($aPairPermissions) //plese remember that this checker does OR check for permissions
                    ],
                        'AND'
                    );
                }
            } else { //just account only, no associated permission, add to accounts array
                $justAccounts[] = $elem;
            }
        }

        if (!empty($justAccounts)) {
            $checkers[] = new OA_Admin_SectionAccountChecker($justAccounts); //add checker for accounts only
        }

        return new OA_Admin_Menu_Compound_Checker($checkers, 'OR');
    }
}

    /**
     * TODO refactor as util
     *
     * @param unknown_type $array
     * @param unknown_type $index
     * @param unknown_type $insert_array
     * @param unknown_type $elem
     */
    function array_insert(&$array, $index, &$elem)
    {
        $aLeft = array_splice($array, 0, $index);
        $aLeft[] = $elem;
        $array = array_merge($aLeft, $array);
    }


    /**
     * TODO refactor as util
     */
    function array_make($var)
    {
        if (is_array($var)) {
            return $var;
        } else {
            return [$var];
        }
    }
