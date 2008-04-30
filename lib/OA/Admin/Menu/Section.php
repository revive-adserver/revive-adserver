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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionAccountChecker.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionCheckerFilter.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionPermissionChecker.php');
require_once(MAX_PATH . '/lib/OA/Admin/Menu/SectionTypeFilter.php');

/**
 * Menu section element
 *
 */
class OA_Admin_Menu_Section
{
    var $id; //eg campaign-edit
    var $name; //eg campaign-edit
    var $link; //link to script with params
    var $helpLink; //link to help page
    var $rank; //float value used to resove conflicts between the sections, defaults to 1
    var $exclusive; //bolean value stating whether section should be shown exclusively (no sibling sections) when it's active //TODO change to type
    var $affixed; //bolean value stating whether section should be shown affixed to sibling sections only when it's active //TODO change to type
    var $aSections; //list of subsections
    var $oSectionChecker; //checker used to decide whether this section can be shown to the user
    var $parentSection; //reference to parent section
    var $aSectionsMap; //hash holding id => section

    /**
     * Enter description here...
     *
     * @param string $id
     * @param string $name
     * @param string $link
     * @param string $helpLink
     * @param array $aAccountPermissions
     * @param float $rank
     * @param boolean $exclusive
     * @param boolean $affixed
     * @return OA_Admin_Menu_Section
     */
    function OA_Admin_Menu_Section($id, $name, $link, $exclusive = false, $helpLink = null, $aAccountPermissions = array(), $rank = 1, $affixed = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
        $this->helpLink = $helpLink;
        $this->rank = $rank;
        $this->exclusive = $exclusive;
        $this->affixed = $affixed;
        $this->aSections = array();
        $this->oSectionChecker = $this->_createSecurityChecker($aAccountPermissions);
        $this->aSectionsMap = array();
    }


	function getId()
	{
        return $this->id;
	}


	function getName()
	{
	    return $this->name;
	}


	function getLink($aParams)
	{
	    return $this->setLinkParams($aParams);
	}

	function setLinkParams($aParams)
	{
        if (strpos($this->link,'?'))
        {
            foreach ($aParams as $arg => $val)
            {
                $this->link = str_replace('{'.$arg.'}',$val,$this->link);
            }
        }
        return $this->link;
	}

	function getHelpLink()
	{
	    return $this->helpLink;
	}


	function getRank()
	{
	    return $this->rank;
	}


	function isExclusive()
	{
	    return $this->exclusive;
	}


    function isAffixed()
    {
        return $this->affixed;
    }


    /**
     * Returns a child with a given id. If user have no access to this section
     * or if the child does not exists null is returned
     *
     * @param string $sectionId
     * @return OA_Admin_Menu_Section
     */
    function &get($sectionId, $checkAccess = true)
    {
        if (!array_key_exists($sectionId, $this->aSectionsMap)) { //TODO use isset instead of array_key_exists
            $errMsg = "MenuSection::get() Cannot get section. No such section with id '".$sectionId."'";
            OA::debug($errMsg, PEAR_LOG_WARNING);
            return null;
        }

        $oSection = &$this->aSectionsMap[$sectionId];

        if ($checkAccess) {
            $checker =  &$oSection->getChecker();
            if (!$checker->check($oSection)) {
                $oSection =  null;
            }

        }

        return $oSection;
    }


    /**
     * Gets a list of child sections
     * @param boolean $checkAccess indicates whether checks should permormed before letting user access sections
     */
	function getSections($checkAccess = true)
	{
	   $aSections = &$this->aSections;

	   if ($checkAccess) {
	       $aSections = array_values(array_filter($aSections, array(new OA_Admin_SectionCheckerFilter(), 'accept')));
	       //TODO remove filter, use either foreach or a callback in menusection object
	   }

	   return $aSections;
	}


	/**
	 * Returns the parent section of this section
	 *
	 * @return OA_Admin_Menu_Section
	 */
	function &getParent()
	{
	   return $this->parentSection;
	}


	function setParent(&$section)
	{
	   $this->parentSection = &$section;
	}


    function &getChecker()
    {
      return $this->oSectionChecker;
    }


    function setChecker(&$oChecker)
    {
        $this->oSectionChecker = &$oChecker;
    }


    //BUILDER FUNCTIONS - not secured
    /**
     * Appends new section to the list of subsections. If element cannot be
     * added (eg. this is attempt to add it for the second time error is returned.
     *
     */
    function add(&$section)
    {
        //check if added section is unique in menu
        if (array_key_exists($section->getId(), $this->aSectionsMap)) {
            $errMsg = "MenuSection::add() Cannot add section '".$section->getId()."': section with given id already exists";
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
    function insertBefore($existingSectionId, &$newSection)
    {
    	  //check parent
        if (!array_key_exists($existingSectionId, $this->aSectionsMap)) {
            $errMsg = "MenuSection::insertBefore() Cannot insert section '".$newSection->getId()."' before a non existent menu section with id '".$existingSectionId."'";
            return MAX::raiseError($errMsg);
        }

        //check if added section is unique in menu
        if (array_key_exists($newSection->getId(), $this->aSectionsMap)) {
            $errMsg = "MenuSection::insertBefore() Cannot insert section '".$newSection->getId()."': section with given id already exists";
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
    function insertAfter($existingSectionId, &$newSection)
    {
        if (!array_key_exists($existingSectionId, $this->aSectionsMap)) {
            $errMsg = "MenuSection::insertAfter() Cannot insert section '".$newSection->getId()."' after a non existent menu section with id '".$existingSectionId."'";
            return MAX::raiseError($errMsg);
        }

        //check if added section is unique in menu
        if (array_key_exists($newSection->getId(), $this->aSectionsMap)) {
            $errMsg = "MenuSection::insertAfter() Cannot insert section '".$newSection->getId()."': section with given id already exists";
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
    function _getSectionIndex($key, &$sections)
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
    function _addToHash(&$section)
    {
      //add new section to flat array
      $this->aSectionsMap[$section->getId()] = &$section;
    }


    function _createSecurityChecker($aAccountPermissionPairs)
    {
    	$checkers = array();

    	for ($pairIdx = 0; $pairIdx < count($aAccountPermissionPairs); $pairIdx++) {
        //$elem can be
        // 1) a single element then it should be an account eg OA_ADMIN_ACCOUNT
        // 2) an 2 element array
        //    - elem[0] stores account(s) and can be:
        //        * a single account element eg OA_ADMIN_ACCOUNT
        //        * an array of accounts eg. array(OA_ADMIN_ACCOUNT, OA_MANAGER_ACCOUNT)
        //    - elem[1] stores permissions(s) and can be:
        //        * a single permission element eg OA_OA_PERM_ZONE_INVOCATION
        //        * an array of permissions eg. array(OA_PERM_ZONE_INVOCATION, OA_PERM_SUPER_ACCOUNT)
    		// If elem[0] is an array it is assumed that every account from that array should be associated with elem[1] permissions

    		$elem =  $aAccountPermissionPairs[$pairIdx];
    		if (is_array($elem)) { //(account,perm) pair
    			$aPairAccounts = array_make($elem[0]);
    			$aPairPermissions = array_make($elem[1]);

            for ($i = 0; $i <  count($aPairAccounts); $i++) {
    			  $checkers[] = &new OA_Admin_Menu_Checker(
    			    array(
    			      new OA_Admin_SectionAccountChecker($aPairAccounts[$i]),
    			      new OA_Admin_SectionPermissionChecker($aPairPermissions) //plese remember that this checker does OR check for permissions
    			    ),
    			    'AND'
    			  );
    			}
    		}
    		else { //just account only, no associated permission, add to accounts array
    			$justAccounts[] = $elem;
    		}
    	}

    	if (!empty($justAccounts)) {
            $checkers[] = &new OA_Admin_SectionAccountChecker($justAccounts); //add checker for accounts only
    	}

        return new OA_Admin_Menu_Checker($checkers, 'OR');
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
        }
        else {
            return array($var);
        }
    }
?>