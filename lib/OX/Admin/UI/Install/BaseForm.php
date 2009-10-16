<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_BaseForm 
    extends OA_Admin_UI_Component_Form
{
    /**
     * OX translation class
     *
     * @var OX_Translation
     */
    protected $oTranslation;    

    /**
     * Builds Database details form.
     * @param OX_Translation $oTranslation  instance
     */
    public function __construct($formName='', $method='POST', $action='', $attributes=null, $oTranslation=null)
    {
        parent::__construct($formName, $method, $action, '', $attributes, true);
        $this->forceClientValidation(true);
        $this->oTranslation = $oTranslation; 
    }
    
    
    protected function getRequiredFieldMessage($fieldLabel)
    {
        return $this->oTranslation->translate('XRequiredField', array($fieldLabel));
    }
    
    
    protected function addRequiredRule($fieldName, $fieldLabel)
    {
        $this->addRule($fieldName, $this->getRequiredFieldMessage($fieldLabel), 'required');
    }
    
    
}

?>