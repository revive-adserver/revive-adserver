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

require_once(MAX_PATH . '/lib/OA/Cache.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/Section.php');


/**
 * A UI menu related methods
 *
 * @package    OpenXAdmin
 */
class OA_Admin_Menu
{
    public $ROOT_SECTION_ID;
    public $rootSection;
    public $aAllSections;
    public $aLinkParams;

    /**
     * Array of included checker path
     *
     * @var array
     */
    public $aCheckerIncludePaths;

    public function __construct()
    {
        $this->ROOT_SECTION_ID = 'root';
        $this->rootSection = new OA_Admin_Menu_Section($this->ROOT_SECTION_ID, 'root', '', '');
        $this->aAllSections = [];
    }

    /**
     * Returns the instance of menu. Subsequent calls return the same object.
     *
     * @return OA_Admin_Menu
     */
    public static function singleton()
    {
        $accountType = OA_Permission::getAccountType();
        if (isset($GLOBALS['_MAX']['MENU_OBJECT'][$accountType])) {
            $oMenu = &$GLOBALS['_MAX']['MENU_OBJECT'][$accountType];
        } elseif ($GLOBALS['_MAX']['CONF']['debug']['production'] != 0 // in debug mode, we don't load the menu from cache
                && $oMenu = OA_Admin_Menu::_loadFromCache($accountType)) {
            $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
        } else {
            $oMenu = new OA_Admin_Menu();
            if (empty($oMenu->aAllSections)) {
                include_once MAX_PATH . '/lib/OA/Admin/Menu/config.php';
                $oMenu = _buildNavigation(OA_Permission::getAccountType());
            }
            require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';
            $oPluginManager = new OX_Plugin_ComponentGroupManager();
            $oPluginManager->mergeMenu($oMenu, $accountType);
            $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
            $oMenu->_saveToCache($accountType);
        }
        // Filter against user-account-preferences...
        return $oMenu;
    }

    public static function _loadFromCache($accountType)
    {
        $oCache = new OA_Cache('Menu', $accountType);
        $oCache->setFileNameProtection(false);
        $aMenu = $oCache->load(true);
        if (!is_array($aMenu)) {
            return false;
        }
        if ($aMenu['checkerPaths']) {
            foreach ($aMenu['checkerPaths'] as $path) {
                if (!@include_once MAX_PATH . $path) {
                    return false;
                }
            }
        }
        return unserialize($aMenu['oMenu']);
    }


    public function _saveToCache($accountType)
    {
        $oCache = new OA_Cache('Menu', $accountType);
        $oCache->setFileNameProtection(false);
        return $oCache->save([ 'checkerPaths' => $this->aCheckerIncludePaths, 'oMenu' => serialize($this)]);
    }


    public static function _clearCache($accountType)
    {
        $oCache = new OA_Cache('Menu', $accountType);
        $oCache->setFileNameProtection(false);
        return $oCache->clear();
    }


    public function _setLinkParams($aParams)
    {
        $this->aLinkParams = $aParams;
    }


    /**
     * Get menu section with a given name
     *
     * @param String $sectionId section to be retrieved
     * @param boolean $checkAccess indicates whether menu should perform checks before letting user access section
     *
     * @return OA_Admin_Menu_Section
     */
    public function get($sectionId, $checkAccess = true)
    {
        //if (!array_key_exists($sectionId, $this->aAllSections)) {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
//            $errMsg = "Menu::get() Cannot get section '".$sectionId."': no such section found. Returning null.";
//            OA::debug($errMsg, PEAR_LOG_WARNING);
            return null;
        }

        $oSection = &$this->aAllSections[$sectionId];

        if ($checkAccess && !$oSection->check()) {
            $oSection = null;
        }

        return $oSection;
    }


    public function removeSection($sectionId)
    {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::get() Cannot get section '" . $sectionId . "': no such section found. Returning null.";
            OA::debug($errMsg, PEAR_LOG_WARNING);
            return null;
        }

        unset($this->aAllSections[$sectionId]);

        return (!array_key_exists($sectionId, $this->aAllSections));
    }


    /**
     * Gets a list of root sections
     * @param boolean $checkAccess indicates whether menu should perform checks before letting user access section
     */
    public function getRootSections($checkAccess = true)
    {
        $aSections = $this->rootSection->getSections();

        if ($checkAccess) {
            $aSections = array_values(array_filter($aSections, [new OA_Admin_SectionCheckerFilter(), 'accept']));
        }

        return $aSections;
    }


    /**
     * Inficates whether given section is a root section.
     *
     * @param OA_Admin_Menu_Section $oSection
     * @param boolean $checkAccess indicates whether menu should perform checks before letting user access section
     * @return boolean
     */
    public function isRootSection($oSection, $checkAccess = true)
    {
        $rootSections = $this->getRootSections($checkAccess);

        return in_array($oSection, $rootSections, true);
    }


    /**
     * Returns a list of parents section starting at the root of the tree
     * eg. for the following structure where A,B,C,D are sections:
     * |-A
     * | |-B
     * |   |-C
     * |     |-D
     *
     * A call getSections('D') will return array(A, B, C)
     *
     * There is an assumption that if section is accessible for the user, it's parents also are
     *
     * @param String $sectionId
     * @param boolean $checkAccess indicates whether menu should perform checks before letting user access section
     * @return array of OA_Admin_Menu_Section being parents of the section with given id
     */
    public function getParentSections($sectionId, $checkAccess = true)
    {
        $aParents = [];

        if (!array_key_exists($sectionId, $this->aAllSections)) {
            /*$errMsg = "Menu::getParentSections() Cannot get parents for section '".$sectionId."': no such section found. Returning an empty array";
            OA::debug($errMsg, PEAR_LOG_WARNING);*/
            return $aParents;
        }

        $oSection = &$this->aAllSections[$sectionId];

        if ($checkAccess && !$oSection->check()) {
            return $aParents;
        }

        $rootSectionId = $this->rootSection->getId();
        $parent = &$oSection->getParent();
        $parentId = $parent->getId();
        while ($parentId != $rootSectionId) {
            $aParents[] = &$parent;
            $oSection = &$parent;
            $parent = &$oSection->getParent();
            $parentId = $parent->getId();
        }

        return array_reverse($aParents);
    }


    /**
     * Returns a nesting level of section with given id (starting at the root which is 0)
     * in menu tree
     * eg. for the following structure where A,B,C,D are sections:
     * |-A
     * | |-B
     * |   |-C
     * |     |-D
     *
     * A call getLevel('D') will return 3
     *
     * There is an assumption that if section is accessible for the user, it's parents also are.
     * Result will be -1 if you do not have rights to access this section.
     *
     * @param String $sectionId
     * @param boolean $checkAccess indicates whether menu should perform checks before letting user access section  level
     * @return int section level (number of parents sections up the tree) or -1  if security check fails or no such section found
     */
    public function getLevel($sectionId, $checkAccess = true)
    {
        $level = -1;
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            /*$errMsg = "Menu::getParentSections() Cannot get parents for section '".$sectionId."': no such section found. Returning an empty array";
            OA::debug($errMsg, PEAR_LOG_WARNING);*/
            return $level;
        }

        $oSection = &$this->aAllSections[$sectionId];
        if ($checkAccess && !$oSection->check()) {
            return $level;
        }

        $aParents = $this->getParentSections($sectionId, $checkAccess);

        return count($aParents);
    }



    /**
     * This method gets the "next" page, the logic is currently:
     * Get the next tab on the current level, if this is the last tab, go to the parent tab
     *
     * @param string $sectionId
     * @return object OA_Admin_Menu_Section
     */
    public function getNextSection($sectionId)
    {
        $parentSections = $this->getParentSections($sectionId);
        if (empty($parentSections)) {
            return $this->get($sectionId);
        }
        $parentSection = $parentSections[count($parentSections) - 1];

        $self = false;
        foreach ($parentSection->aSectionsMap as $sectionName => $section) {
            if ($sectionName == $sectionId) {
                $self = true;
                continue;
            }
            if ($self) {
                return $section;
            }
        }
        return $parentSection;
    }

    //BUILDER methods - not secured
    /**
     * Add new section as a top level section. If element cannot be
     * added (eg. this is attempt to add it for the second time error is returned.
     *
     * @param OA_Admin_Menu_Section $oSection section to be added
     * @return true if element was added, MAX:raiseError() in case it fails.
     */
    public function add($oSection)
    {
        return $this->addTo($this->ROOT_SECTION_ID, $oSection);
    }


    /**
     * Adds a given section to a section with given id.
     * Add new section as a top level section. If add was successful true is
     * returned. Error is retunred when element cannot because:
     * - there is no such sectin with $parentSectionId to add to
     * - section with given id already exists in the tree
     *
     * @param String $parentSectionId parent id
     * @param OA_Admin_Menu_Section $oSection section to be added
     *
     * @return true|PEAR_Error if element was added, MAX:raiseError() in case it fails.
     */
    public function addTo($parentSectionId, $oSection)
    {
        if ($parentSectionId == $this->ROOT_SECTION_ID) {
            $parentSection = &$this->rootSection;
        } elseif (array_key_exists($parentSectionId, $this->aAllSections)) { //TODO replace with isset($this->aAllSections[$parentSectionId])
            $parentSection = &$this->aAllSections[$parentSectionId];
        } else {
            $errMsg = "Menu::addTo() Cannot add section '" . $oSection->getId() . "' to a non existent menu section with id '" . $parentSectionId . "'";
            return MAX::raiseError($errMsg);
        }

        //check if added section is unique in menu
        if (array_key_exists($oSection->getId(), $this->aAllSections)) {
            $errMsg = "Menu::addTo() Cannot add section '" . $oSection->getId() . "' to section '" . $parentSectionId . "'. Section with given id already exists";
            return MAX::raiseError($errMsg);
        }


        //add to parent
        $parentSection->add($oSection);

        //add new section to hash array
        $this->_addToHash($oSection);

        return true; //TODO return added section here
    }


    public function insertBefore($sectionId, $oSection)
    {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::insertBefore() Cannot insert section '" . $oSection->getId() . "' before a non existent menu section with id '" . $sectionId . "'";
            return MAX::raiseError($errMsg);
        }
        $siblingSection = &$this->aAllSections[$sectionId];
        $parent = &$siblingSection->getParent();
        $result = $parent->insertBefore($sectionId, $oSection);

        //add new section to hash array
        if (!PEAR::isError($result)) {
            $this->_addToHash($oSection);
        }

        return $result;
    }


    public function insertAfter($sectionId, $oSection)
    {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::insertAfter() Cannot insert section '" . $oSection->getId() . "' after a non existent menu section with id '" . $sectionId . "'";
            return MAX::raiseError($errMsg);
        }
        $siblingSection = &$this->aAllSections[$sectionId];
        $parent = &$siblingSection->getParent();
        $result = $parent->insertAfter($sectionId, $oSection);

        //add new section to hash array
        if (!PEAR::isError($result)) {
            $this->_addToHash($oSection);
        }

        return $result;
    }


    /**
     * Additional hook. Allows to plug third level itemAdd third level
     */
    public function addThirdLevelTo($sectionId, $oSection)
    {
        $oSection->setType(OA_Admin_Menu_Section::TYPE_LEFT_SUB);
        $this->addTo($sectionId, $oSection);
    }


    /**
     * Private
     *
     * @param OA_Admin_Menu_Section $oSection
     */
    public function _addToHash($oSection)
    {
        //add new section to flat array
        $this->aAllSections[$oSection->getId()] = &$oSection;
    }


    /**
     * Gets list of other publishers and set a menu page context variable with them
     * Can be easily reused across inventory->publishers pages
     *
     * TODO: Consider reading page name from automatically instead of passing it as a parameter
     *
     * @static
     * @param integer $affiliateid  Affiliate ID
     * @param string $pageName
     * @param string $sortPageName
     */
    public static function setPublisherPageContext($affiliateid, $pageName, $sortPageName = 'website-index.php')
    {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = OA_Permission::getAgencyId();
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $doAffiliates->affiliateid = $affiliateid;
        }
        $doAffiliates->addSessionListOrderBy($sortPageName);
        $doAffiliates->find();
        while ($doAffiliates->fetch()) {
            phpAds_PageContext(
                phpAds_buildAffiliateName($doAffiliates->affiliateid, $doAffiliates->name),
                "$pageName?affiliateid=" . $doAffiliates->affiliateid,
                $affiliateid == $doAffiliates->affiliateid
            );
        }
    }


    /**
     * Gets list of other advertisers and set a menu page context variable with them
     * Can be easily reused across inventory->advertisers pages
     *
     * TODO: Consider reading page name from automatically instead of passing it as a parameter
     *
     * @static
     * @param integer $clientid  Advertiser ID
     * @param string $pageName
     * @param string $sortPageName
     */
    public static function setAdvertiserPageContext($clientid, $pageName, $sortPageName = 'advertiser-index.php')
    {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = OA_Permission::getEntityId();
        $doClients->addSessionListOrderBy($sortPageName);
        $doClients->find();

        while ($doClients->fetch()) {
            phpAds_PageContext(
                phpAds_buildName($doClients->clientid, $doClients->clientname),
                "$pageName?clientid=" . $doClients->clientid,
                $clientid == $doClients->clientid
            );
        }
    }


    public static function setAgencyPageContext($agencyid, $pageName)
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->find();
        while ($doAgency->fetch()) {
            phpAds_PageContext(
                phpAds_buildName($doAgency->agencyid, $doAgency->name),
                "$pageName?agencyid=" . $doAgency->agencyid,
                $agencyid == $doAgency->agencyid
            );
        }
    }

    /**
     * Store checker include path
     *
     * @param string $checkerClassName
     * @param string $fullPath
     */
    public function addCheckerIncludePath($checkerClassName, $path)
    {
        $this->aCheckerIncludePaths[$checkerClassName] = $path;
    }
}
