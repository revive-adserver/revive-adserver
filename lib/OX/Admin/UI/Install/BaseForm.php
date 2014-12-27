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

require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
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