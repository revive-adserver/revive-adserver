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
require_once 'BaseForm.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_ConfigForm 
    extends OX_Admin_UI_Install_BaseForm
{
    /**
     * Available admin languages
     * @var array associative array of lanugage code to label 
     */
    private $aLanguages;    
    
    /**
     * Available timezones
     * @var array associative array of timezone code to label 
     */    
    private $aTimezones;

    /**
     * Builds Database details form.
     * @param OX_Translation $oTranslation  instance
     */
    public function __construct($oTranslation, $action, $availableLanguages, $availableTimezones, $isUpgrade, $prevPathRequired = false)
    {
        parent::__construct('install-config-form', 'POST', $_SERVER['SCRIPT_NAME'], null, $oTranslation);
        $this->aLanguages = $availableLanguages;
        $this->aTimezones = $availableTimezones;
        
        $this->addElement('hidden', 'action', $action); 
        
        if ($prevPathRequired)  {
            $this->buildPreviousPathSection();
        }
        
        if (!$isUpgrade) {
            $this->buildAdminSection();
            $this->buildPathsConfigurationSection();
        }
        
        $this->addElement('controls', 'form-controls');
        $this->addElement('submit', 'save', $GLOBALS['strBtnContinue']);          
    }


    protected function buildAdminSection()
    {
        $this->addElement('hidden', 'moreFieldsShown', 0, array('id' => 'moreFieldsShown'));
    
        //build form
        $this->addElement('header', 'h_admin', $GLOBALS['strAdminAccount']);
        $this->addElement('text', 'adminName', $GLOBALS['strAdminUsername'], array('class' => 'medium'));
        $this->addElement('password', 'adminPassword', $GLOBALS['strAdminPassword'], array('class' => 'medium'));
        $this->addElement('password', 'adminPassword2', $GLOBALS['strRepeatPassword'], array('class' => 'medium'));
        $this->addElement('text', 'adminEmail', $GLOBALS['strAdministratorEmail'], array('class' => 'medium'));
        $this->addElement('select', 'adminLanguage', $GLOBALS['strLanguage'], $this->aLanguages, array('class' => 'small'));        
        $this->addElement('select', 'prefsTimezone', $GLOBALS['strTimezone'], $this->aTimezones, array('class' => 'medium'));        
        $this->addElement('static', 'moreFields', '<a href="#" id="showMoreFields">'.$GLOBALS['strConfigSeeMoreFields'].'</a>');
        
        //Form validation rules
        $this->addRequiredRule('adminName', $GLOBALS['strAdminUsername']);
        $this->addRequiredRule('adminPassword', $GLOBALS['strAdminPassword']);
        $this->addRequiredRule('adminPassword2', $GLOBALS['strRepeatPassword']);
        $this->addRequiredRule('adminEmail', $GLOBALS['strAdministratorEmail']);
        $this->addRule('adminEmail', $GLOBALS['strEmailField'], 'email');        
        $this->addRequiredRule('adminLanguage', $GLOBALS['strLanguage']);
        $this->addRequiredRule('prefsTimezone', $GLOBALS['strTimezone']);
    }
    
    
    protected function buildPathsConfigurationSection()
    {
        $http = "http://";  
        $https = "https://";
        $http_s = "http(s)://";
        
        //build form
        $this->addElement('header', 'h_paths', $GLOBALS['strConfigurationSettings']);
        $this->addElement('text', 'webpathAdmin', $GLOBALS['strWebPathSimple'], 
            array('prefix' => $http_s, 'class' => 'large'));
        $this->addElement('text', 'webpathDelivery', $GLOBALS['strDeliveryPath'], 
            array('prefix' => $http, 'class' => 'large'));
        $this->addElement('text', 'webpathImages', $GLOBALS['strImagePath'], 
            array('prefix' => $http, 'class' => 'large'));
        $this->addElement('text', 'webpathDeliverySSL', $GLOBALS['strDeliverySslPath'], 
            array('prefix' => $https, 'class' => 'large'));
        $this->addElement('text', 'webpathImagesSSL', $GLOBALS['strImageSslPath'], 
            array('prefix' => $https, 'class' => 'large'));
        $this->addElement('text', 'storeWebDir', $GLOBALS['strImageStore'], 
            array('class' => 'large'));
        
        //Form validation rules
        $this->addRequiredRule('webpathAdmin', $GLOBALS['strWebPathSimple']);
        $this->addRequiredRule('webpathDelivery', $GLOBALS['strDeliveryPath']);
        $this->addRequiredRule('webpathImages', $GLOBALS['strImagePath']);
        $this->addRequiredRule('webpathDeliverySSL', $GLOBALS['strDeliverySslPath']);
        $this->addRequiredRule('webpathImagesSSL', $GLOBALS['strImageSslPath']);
        $this->addRequiredRule('storeWebDir', $GLOBALS['strImageStore']);
        
        
        $this->addDecorator('h_paths', 'tag', array('tag' => 'div',
            'attributes' => array('id' => 'moreFields', 'class' => 'hide')));        
    }
    

    protected function buildPreviousPathSection()
    {
        //build form
        $this->addElement('header', 'h_old_path', $GLOBALS['strPreviousInstallTitle']);
        $this->addElement('text', 'previousPath', $GLOBALS['strPathToPrevious'], 
            array('class' => 'medium'));
        //Form validation rules
        $this->addRequiredRule('previousPath', $GLOBALS['strPathToPrevious']);
    }    
    

    /**
     * Generates admin and path configuration details array. The structure is the following 
     * and  it reflects $oUpgrader->aDsn structure.
     * 
     * $aConfig['webpath']['admin']  
     * $aConfig['webpath']['delivery']
     * $aConfig['webpath']['images']
     * $aConfig['webpath']['deliverySSL']
     * $aConfig['webpath']['imagesSSL']
     * $aConfig['store']['webDir']
     *      *
     * @return array populated $aDatabase array
     */
    public function populateConfig()
    {
        $aFields = $this->exportValues();
        $aConfig = array();
        $aConfig['webpath']['admin'] = $aFields['webpathAdmin'];  
        $aConfig['webpath']['delivery'] = $aFields['webpathDelivery'];
        $aConfig['webpath']['images'] = $aFields['webpathImages'];
        $aConfig['webpath']['deliverySSL'] = $aFields['webpathDeliverySSL'];
        $aConfig['webpath']['imagesSSL'] = $aFields['webpathImagesSSL'];
        $aConfig['store']['webDir'] = $aFields['storeWebDir'];
        $aConfig['previousInstallationPath'] = $aFields['previousPath'];

        $aAdmin = array();
        $aAdmin['name'] = $aFields['adminName'];
        $aAdmin['pword'] = $aFields['adminPassword'];
        $aAdmin['pword2'] = $aFields['adminPassword2'];
        $aAdmin['email'] = $aFields['adminEmail'];
        $aAdmin['language'] = $aFields['adminLanguage'];
        
        $aPrefs = array();
        $aPrefs['timezone'] = $aFields['prefsTimezone'];
        
        
        return array('config' => $aConfig, 'admin' => $aAdmin, 'prefs' => $aPrefs);
    }
    

    /**
     * Populates form with values obtained from $oUpgrader->aDsn database config
     * @param $aDbConfig $oUpgrader->aDsn data
     */
    public function populateForm($aConfig)
    {
        $aFields = array();
        
        $aPathConfig = $aConfig['config'];
        
        //config part
        $aFields = array();
        $aFields['webpathAdmin'] = $aPathConfig['webpath']['admin'];
        $aFields['webpathDelivery'] = $aPathConfig['webpath']['delivery'];
        $aFields['webpathImages'] = $aPathConfig['webpath']['images'];
        $aFields['webpathDeliverySSL'] = $aPathConfig['webpath']['deliverySSL'];
        $aFields['webpathImagesSSL'] = $aPathConfig['webpath']['imagesSSL'];
        $aFields['storeWebDir'] =  $aPathConfig['store']['webDir'];
        $aFields['previousPath'] = $aPathConfig['previousInstallationPath'];
        
        
        //admin (do not copy passwords we do not want them in HTML code)
        $aAdmin = $aConfig['admin'];
        $aFields['adminName'] = $aAdmin['name'];
        $aFields['adminEmail'] = $aAdmin['email'];
        $aFields['adminLanguage'] = $aAdmin['language'];        
        
        //prefs
        $aFields['prefsTimezone'] = $aConfig['prefs']['timezone'];               
        
        $this->setDefaults($aFields);
    }    
}

?>