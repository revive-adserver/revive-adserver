<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once(MAX_PATH.'/lib/OA/Cache.php');
require_once(MAX_PATH.'/lib/OA/Admin/Menu/Section.php');


/**
 * A UI menu related methods
 *
 * @package    OpenXAdmin
 */
class OA_Admin_Menu
{
    var $ROOT_SECTION_ID;
    var $rootSection;
    var $aAllSections;
    var $aLinkParams;

    /**
     * Returns the instance of menu. Subsequent calls return the same object.
     *
     * @return OA_Admin_Menu
     */
    function &singleton()
    {
        $accountType = OA_Permission::getAccountType();
        if (isset($GLOBALS['_MAX']['MENU_OBJECT'][$accountType])) {
           $oMenu = &$GLOBALS['_MAX']['MENU_OBJECT'][$accountType];
        }
        else if ($oMenu = OA_Admin_Menu::_loadFromCache($accountType))
        {
            $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
        }
        else
        {
            $oMenu = &new OA_Admin_Menu();
            if (empty($oMenu->aAllSections)) {
                include_once MAX_PATH. '/lib/OA/Admin/Menu/config.php';
                $oMenu = _buildNavigation(OA_Permission::getAccountType());
            }
            $GLOBALS['_MAX']['MENU_OBJECT'][$accountType] = &$oMenu;
        }
        // Filter against user-account-preferences...
        return $oMenu;
    }

    function OA_Admin_Menu()
    {
        $this->ROOT_SECTION_ID = 'root';
        $this->rootSection = &new OA_Admin_Menu_Section($this->ROOT_SECTION_ID, 'root', '', '');
        $this->aAllSections = array();
    }

    function _loadFromCache($accountType)
    {
        $oCache = new OA_Cache('Menu', $accountType);
        $oCache->setFileNameProtection(false);
        return $oCache->load(true);
    }

    function _saveToCache($accountType)
    {
        $oCache = new OA_Cache('Menu', $accountType);
        $oCache->setFileNameProtection(false);
        return $oCache->save($this);
    }

    function _clearCache($accountType)
    {
        $oCache = new OA_Cache('Menu', $accountType);
        $oCache->setFileNameProtection(false);
        return $oCache->clear();
    }

    function _setLinkParams($aParams)
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
    function &get($sectionId, $checkAccess = true)
    {
        //if (!array_key_exists($sectionId, $this->aAllSections)) {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::get() Cannot get section '".$sectionId."': no such section found. Returning null.";
            OA::debug($errMsg, PEAR_LOG_WARNING);
            return null;
        }

        $oSection = &$this->aAllSections[$sectionId];

        if ($checkAccess) {
            $checker =  &$oSection->getChecker();
            if (!$checker->check($oSection)) {
                $oSection = null;
            }
        }

        return $oSection;
    }

    function removeSection($sectionId)
    {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::get() Cannot get section '".$sectionId."': no such section found. Returning null.";
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
    function getRootSections($checkAccess = true)
    {
        $aSections = &$this->rootSection->getSections();

        if ($checkAccess) {
            $aSections = array_values(array_filter($aSections, array(new OA_Admin_SectionCheckerFilter(), 'accept')));
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
    function isRootSection(&$oSection, $checkAccess = true)
    {
        $rootSections = $this->getRootSections($checkAccess);
        return object_in_array($oSection, $rootSections, true);
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
     * @return an array of OA_Admin_Menu_Section being parents of the section with given id
     */
    function getParentSections($sectionId, $checkAccess = true)
    {
        $aParents = array();

        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::getParentSections() Cannot get parents for section '".$sectionId."': no such section found. Returning an empty array";
            OA::debug($errMsg, PEAR_LOG_ERROR);
            return $aParents;
        }

        $oSection = &$this->aAllSections[$sectionId];
        $checker = &$oSection->getChecker();

        if ($checkAccess && !$checker->check($oSection)) {
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
     * This method gets the "next" page, the logic is currently:
     * Get the next tab on the current level, if this is the last tab, go to the parent tab
     *
     * @param string $sectionId
     * @return object OA_Admin_Menu_Section
     */
    function getNextSection($sectionId)
    {
        $parentSections = $this->getParentSections($sectionId);
        if (empty($parentSections)) {
            return $this->get($sectionId);
        }
        $parentSection = $parentSections[count($parentSections)-1];

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
     * @param OA_Admin_Menu_Section $section section to be added
     * @return true if element was added, MAX:raiseError() in case it fails.
     */
    function add(&$section)
    {
        return $this->addTo($this->ROOT_SECTION_ID, $section);
    }


    /**
     * Adds a given section to a section with given id.
     * Add new section as a top level section. If add was successful true is
     * returned. Error is retunred when element cannot because:
     * - there is no such sectin with $parentSectionId to add to
     * - section with given id already exists in the tree
     *
     * @param String $parentSectionId parent id
     * @param OA_Admin_Menu_Section $section section to be added
     * @return true if element was added, MAX:raiseError() in case it fails.
     */
    function addTo($parentSectionId, &$section)
    {
        if ($parentSectionId == $this->ROOT_SECTION_ID) {
            $parentSection = &$this->rootSection;
        }
        else if (array_key_exists($parentSectionId, $this->aAllSections)) { //TODO replace with isset($this->aAllSections[$parentSectionId])
            $parentSection = &$this->aAllSections[$parentSectionId];
        }
        else {
            $errMsg = "Menu::addTo() Cannot add section '".$section->getId()."' to a non existent menu section with id '".$parentSectionId."'";
            return MAX::raiseError($errMsg);
        }

        //check if added section is unique in menu
        if (array_key_exists($section->getId(), $this->aAllSections)) {
            $errMsg = "Menu::addTo() Cannot add section '".$section->getId()."' to section '".$parentSectionId."'. Section with given id already exists";
            return MAX::raiseError($errMsg);
        }


        //add to parent
        $parentSection->add($section);

        //add new section to hash array
        $this->_addToHash($section);

        return true; //TODO return added section here
    }


    function insertBefore($sectionId, &$section)
    {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::insertBefore() Cannot insert section '".$section->getId()."' before a non existent menu section with id '".$sectionId."'";
            return MAX::raiseError($errMsg);
        }
        $siblingSection = &$this->aAllSections[$sectionId];
        $parent = &$siblingSection->getParent();
        $result = $parent->insertBefore($sectionId, $section);

        //add new section to hash array
        if (!PEAR::isError($result)) {
            $this->_addToHash($section);
        }

        return $result;
    }


    function insertAfter($sectionId, &$section)
    {
        if (!array_key_exists($sectionId, $this->aAllSections)) {
            $errMsg = "Menu::insertAfter() Cannot insert section '".$section->getId()."' after a non existent menu section with id '".$sectionId."'";
            return MAX::raiseError($errMsg);
        }
        $siblingSection = &$this->aAllSections[$sectionId];
        $parent = &$siblingSection->getParent();
        $result = $parent->insertAfter($sectionId, $section);

        //add new section to hash array
        if (!PEAR::isError($result)) {
            $this->_addToHash($section);
        }

        return $result;
    }

    /**
     * Private
     *
     * @param unknown_type $section
     */
    function _addToHash(&$section)
    {
        //add new section to flat array
        $this->aAllSections[$section->getId()] = &$section;
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
    function setPublisherPageContext($affiliateid, $pageName, $sortPageName = 'affiliate-index.php')
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
                phpAds_buildAffiliateName ($doAffiliates->affiliateid, $doAffiliates->name),
                "$pageName?affiliateid=".$doAffiliates->affiliateid,
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
    function setAdvertiserPageContext($clientid, $pageName, $sortPageName = 'advertiser-index.php')
    {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = OA_Permission::getEntityId();
        $doClients->addSessionListOrderBy($sortPageName);
        $doClients->find();

        while ($doClients->fetch()) {
            phpAds_PageContext(
              phpAds_buildName ($doClients->clientid, $doClients->clientname),
                "$pageName?clientid=".$doClients->clientid,
                $clientid == $doClients->clientid
            );
        }
    }


    function setAgencyPageContext($agencyid, $pageName)
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->find();
        while ($doAgency->fetch()) {
            phpAds_PageContext(
              phpAds_buildName ($doAgency->agencyid, $doAgency->name),
              "$pageName?agencyid=".$doAgency->agencyid,
              $agencyid == $doAgency->agencyid
            );
        }
    }
}
/**
/* TODO refactor as util
 * in_array throws errors for PHP4 if object is passed as a needle...
 *
 * Uses some code from lib/simpletest/compatibility.php
 *
 * @param object $needle
 * @param array of objects $haystack
 * @param boolean $strict (defaults to false)
 */
function object_in_array(&$needle  , &$haystack, $strict = false)
{
    if (version_compare(phpversion(), '5', '>=')) {
        return in_array($needle, $haystack, $strict);
    }

	$equal = false;
    for ($i = 0; $i < count($haystack); $i++) {
    	$hayElem = &$haystack[$i];
        if (is_object($needle) && is_object($hayElem)) {
            $id = uniqid("test");
            $needle->$id = true;
            $equal = isset($hayElem->$id);
            unset($needle->$id);
        }
        else {
	        $temp = $needle;
	        $needle = uniqid("test");
	        $equal = ($needle === $hayElem);
	        $needle = $temp;
        }

        if ($equal == true) {
            break;
        }
    }

    return $equal;
}

?>