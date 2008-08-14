<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id:$
*/

/**
 * @package    OpenXDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 *
 */

require_once MAX_PATH . '/lib/pear/Date.php';


/**
 * Base class for all info classes
 *
 */
class OA_Info
{

    /**
     * This method should be redeclared in the inherited classes.
     *
     */
    function getFieldsTypes()
    {
        die('Please define this method in each derivative class');
    }

    /**
     * This method returns class field type.
     *
     * @param string $fieldName
     * @return string  field type
     */
    function getFieldType($fieldName)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        if (!isset($aFieldsTypes) || !is_array($aFieldsTypes)) {
            MAX::raiseError('Please provide field types array for Info object creation');
        }

        if (!array_key_exists($fieldName, $aFieldsTypes)) {
            MAX::raiseError('Unknown type for field \'' . $fieldName .'\'');
        }
        return $aFieldsTypes[$fieldName];
    }

    /**
     * This method initialises object from array.
     *
     * @param array $aEntityData
     */
    function readDataFromArray($aEntityData)
    {
        $aFieldsTypes = $this->getFieldsTypes();
        foreach($aFieldsTypes as $fieldName => $fieldType) {
            if (array_key_exists($fieldName, $aEntityData)) {
                if ($fieldType == 'date') {
                    // If the date is 'no date' then don't return this element in the response at all.
                    if (empty($aEntityData[$fieldName]) ||
                        $aEntityData[$fieldName] == OA_Dal::noDateValue()) {
                        unset($this->$fieldName);
                    } else {
                        $this->$fieldName = new Date($aEntityData[$fieldName]);
                    }                        
                } else {
                    $this->$fieldName = $aEntityData[$fieldName];
                }
            }
        }
    }

    function toArray()
    {
        return (array)$this;
    }
}

?>