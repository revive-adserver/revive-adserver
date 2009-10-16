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
require_once 'BaseForm.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_DbForm 
    extends OX_Admin_UI_Install_BaseForm
{
    private $aDbTypes;
    private $aTableTypes;
    

    /**
     * Builds Database details form.
     * @param OX_Translation $oTranslation  instance
     * @param string action name to post form
     * @param array $supportedDbTypes
     * @param array $supportedTableTypes
     * @param boolean $isUpgrade indicates if that's install or upgrade
     * @param boolean $hasTimezoneError indicates if timezone error during upgrade should be shown
     */
    public function __construct($oTranslation, $action, $supportedDbTypes, $supportedTableTypes, $isUpgrade, $hasTimezoneError = false)
    {
        parent::__construct('install-db-form', 'POST', $_SERVER['SCRIPT_NAME'], null, $oTranslation);
        $this->aDbTypes = $supportedDbTypes;
        $this->aTableTypes = $supportedTableTypes;
        
        $this->addElement('hidden', 'action', $action);
        
        if ($hasTimezoneError) {
            $this->buildTimezoneSection();
        }
        
        if ($isUpgrade) {
            $this->buildUpgradeDbViewSection();
        }
        else {
            $this->buildMainDbSection();
            $this->buildAdditionalDbSection();
        }
        
        $this->addElement('controls', 'form-controls');
        $this->addElement('submit', 'save', $GLOBALS['strBtnContinue']);          
    }


    protected function buildMainDbSection()
    {
        $this->addElement('hidden', 'moreFieldsShown', 0, array('id' => 'moreFieldsShown'));
    
        //build form
        $this->addElement('header', 'h_db_main', $GLOBALS['strDatabaseSettings']);
        $this->addElement('text', 'dbName', $GLOBALS['strDbName'], array('class' => 'medium', 'id' => 'dbName', 'suffix' => ' '.$GLOBALS['strDbNameHint']));
        $this->addElement('text', 'dbUser', $GLOBALS['strDbUser'], array('class' => 'medium', 'id' => 'dbUser'));
        $this->addElement('password', 'dbPassword', $GLOBALS['strDbPassword'], array('class' => 'medium', 'id' => 'dbPassword'));
        $this->addElement('text', 'dbHost', $GLOBALS['strDbHost'], array('class' => 'medium', 'id' => 'dbHost'));

        $this->addElement('static', 'moreFields', '<a href="#" id="showMoreFields">'.$GLOBALS['strDbSeeMoreFields'].'</a>');
        
        //Form validation rules
        if(!isset($_POST['dbLocal']) || $_POST['dbLocal'] == 0) {
            $this->addRequiredRule('dbHost', $GLOBALS['strDbHost']); //hostname required if localsocet is not used
        }
        $this->addRequiredRule('dbName', $GLOBALS['strDbName']);
        $this->addRequiredRule('dbUser', $GLOBALS['strDbUser']);
    }
    
    
    protected function buildAdditionalDbSection()
    {
        //build form
        $this->addElement('header', 'h_db_add', $GLOBALS['strAdvancedSettings']);
        
        $this->addElement('select', 'dbType', $GLOBALS['strDbType'], $this->aDbTypes, array('class' => 'small', 'id' => 'dbType'));
        $this->addElement('advcheckbox', 'dbLocal', null,  $GLOBALS['strDbLocal'], array('id' => 'dbLocal'), array(0, 1));
        
        $this->addElement('text', 'dbSocket', $GLOBALS['strDbSocket'], array('class' => 'small', 'id' => 'dbSocket'));
        $this->addElement('text', 'dbPort', $GLOBALS['strDbPort'], array('class' => 'small', 'id' => 'dbPort'));
        
        //db/table types
        $this->addElement('select', 'dbTableType', $GLOBALS['strTablesType'], $this->aTableTypes, array('class' => 'small', 'id' => 'dbTableType'));        
        $this->addElement('text', 'dbTablePrefix', $GLOBALS['strTablesPrefix'], array('class' => 'small', 'id' => 'dbTablePrefix'));

        
        $this->addDecorator('h_db_add', 'tag', array('tag' => 'div',
            'attributes' => array('id' => 'moreFields', 'class' => 'hide')));

        //validation rules
        if ($_POST['dbLocal'] == 1) {
            $this->addRequiredRule('dbSocket', $GLOBALS['strDbSocket']);
        }
        if ($_POST['dbLocal'] == 0) {
            if ($_POST['dbType'] ==  'mysql') {
                $this->addRequiredRule('dbPort', $GLOBALS['strDbPort']);
            }
        }
    }
    
    
    protected function buildUpgradeDbViewSection()
    {
        //build form
        $this->addElement('header', 'h_db_main_view', $GLOBALS['strDatabaseSettings']);
        $this->addElement('static', 'detectedVersion', $GLOBALS['strDetectedVersion'], null, 
            array('class' => 'medium', 'id' => 'dbName'));
        $this->addElement('static', 'dbName', $GLOBALS['strDbName'], null,
            array('class' => 'medium', 'id' => 'dbName'));
        $this->addElement('static', 'dbHost', $GLOBALS['strDbHost'], null,
            array('class' => 'medium', 'id' => 'dbHost'));
            
        $this->addDecorator('h_db_main_view', 'tag', array('tag' => 'div',
            'attributes' => array('class' => 'formView')));
            
    }
    

    protected function buildTimeZoneSection()
    {
        //we want a nice checkbox in warning message, still we want it be a field
        //here's a workaround...
        $warningMessage = $this->oTranslation->translate('DbTimeZoneWarning', array('http://www.openx.org/en/docs/2.8/adminguide/Upgrade+Time+Zones')); 
        $prefix = '<div class="messagePlaceholder messagePlaceholderForm" >
            <div class="message localMessage">
                <div class="panel warning">
                <div class="icon"></div>'.$warningMessage.'<p>';
        $suffix = '</p><div class="topleft"></div>
                <div class="topright"></div>
                <div class="bottomleft"></div>
                <div class="bottomright"></div>
                </div>
            </div>
            </div>';
         
        $this->addElement('advcheckbox', 'noTzAlert', null,  $GLOBALS['strDbTimeZoneNoWarnings'], 
            array('prefix' => $prefix, 'suffix' => $suffix), array(0, 1));
    }
    
    
    /**
     * Generates database configuration details array. The structure is the following 
     * and  it reflects $oUpgrader->aDsn structure.
     * 
     *  $aDatabase['database']['type']  
     *  $aDatabase['database']['localsocket']
     *  $aDatabase['database']['socket']
     *  $aDatabase['database']['host']
     *  $aDatabase['database']['port']
     *  $aDatabase['database']['username']
     *  $aDatabase['database']['password']
     *  $aDatabase['database']['name']
     *  $aDatabase['table']['type']
     *  $aDatabase['table']['prefix']
     *
     * @return array populated $aDatabase array
     */
    public function populateDbConfig()
    {
        $aFields = $this->exportValues();
        $aConfig = array();
        $aDatabase['database']['type'] = $aFields['dbType'];  
        $aDatabase['database']['localsocket'] = $aFields['dbLocal'];
        $aDatabase['database']['socket'] = $aFields['dbSocket'];
        $aDatabase['database']['host'] = $aFields['dbHost'];
        $aDatabase['database']['port'] = $aFields['dbPort'];
        $aDatabase['database']['username'] = $aFields['dbUser'];
        $aDatabase['database']['password'] = $aFields['dbPassword'];
        $aDatabase['database']['name'] = $aFields['dbName'];
        $aDatabase['table']['type'] = $aFields['dbTableType'];
        $aDatabase['table']['prefix'] = $aFields['dbTablePrefix'];

        $aDatabase['noTzAlert'] = $aFields['noTzAlert'];
        
        return $aDatabase;
    }
    
    
    /**
     * Populates form with values obtained from $oUpgrader->aDsn database config
     * @param $aDbConfig $oUpgrader->aDsn data
     */
    public function populateForm($aDbConfig)
    {
        $aFields = array();
        $aFields['dbName'] = $aDbConfig['database']['name'];
        $aFields['dbUser'] = $aDbConfig['database']['username'];
        $aFields['dbHost'] = $aDbConfig['database']['host'];
        $aFields['dbType'] = $aDbConfig['database']['type'];            
        $aFields['dbPort'] = $aDbConfig['database']['port'];
        $aFields['dbLocal'] = $aDbConfig['database']['localsocket'] 
            || $aDbConfig['database']['protocol'] == 'unix';
        $aFields['dbSocket'] = $aDbConfig['database']['socket'];
        $aFields['dbTableType'] = $aDbConfig['table']['type'];
        $aFields['dbTablePrefix'] = $aDbConfig['table']['prefix'];
        $aFields['moreFieldsShown'] = false;
        $aFields['noTzAlert'] = $aDbConfig['noTzAlert'];
         
        $aFields['detectedVersion'] = $aDbConfig['detectedVersion'];
        
        $this->setDefaults($aFields);
    }
}

?>