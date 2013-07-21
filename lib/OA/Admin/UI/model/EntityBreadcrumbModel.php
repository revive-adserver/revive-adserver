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

/**
 * A model describing a page header. Allows to specify title, title icon class, 
 * include breadcrumbs if any.
 * 
 * Newly created model is empty, so if page is given such a model no title nor icon
 * will be displayed.
 * 
 */
class OA_Admin_UI_Model_EntityBreadcrumbModel
{
    /**
     * 
     *
     * @var array
     */
    private $aSegments;
    
    public function __construct()
    {
        $this->aSegments = array();
    }
    
    
    /**
     * Enter description here...
     *
     * @param unknown_type $oSegment
     */
    public function addEntitySegment($oSegment)
    {
        $this->aSegments[] = $oSegment;
    }
}

?>