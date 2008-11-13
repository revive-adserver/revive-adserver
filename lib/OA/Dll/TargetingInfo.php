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
$Id: TargetingInfo.php 27748 2008-11-10 11:12:46Z andriy.petlyovanyy $
*/

/**
 * @package    OpenXDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_PublisherInfo class extends the base OA_Info class and contains
 * information about publisher
 *
 */
class OA_Dll_TargetingInfo extends OA_Info
{
    /**
     * 99% will be "and" or "or", but that's not enforced
     * 
     * @var string
     */
    public $logical;
    
    /**
     * This is the plugin-component identifier
     * 
     * @var string
     */
    public $type;
    
    /**
     * String showing the operation to be applied (e.g.: '==', '!=', '>=', 
     * 'ne')
     * 
     * @var string
     */
    public $comparison;
    
    /**
     * The exact structure varies from component to component
     * 
     * @var string
     */
    public $data;
    
    
    function getFieldsTypes()
    {
        return array(
                    'logical' => 'string',
                    'type' => 'string',
                    'comparison' => 'string',
                    'data' => 'string'
                );
    }
}