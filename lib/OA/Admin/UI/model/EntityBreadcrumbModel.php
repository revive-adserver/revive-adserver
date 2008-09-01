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