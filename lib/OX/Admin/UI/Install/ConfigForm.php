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

require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';
require_once 'BaseForm.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 */
class OX_Admin_UI_Install_ConfigForm extends OX_Admin_UI_Install_BaseForm
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

        if ($prevPathRequired) {
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
        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->addElement('hidden', 'moreFieldsShown', 0, ['id' => 'moreFieldsShown']);

        $this->addElement('static', 'zxcvbn', '<script src="assets/js/zxcvbn.js"></script>');

        //build form
        $this->addElement('header', 'h_admin', $GLOBALS['strAdminAccount']);
        $this->addElement('text', 'adminName', $GLOBALS['strAdminUsername'], ['class' => 'medium', 'autocomplete' => 'username']);
        $this->addElement('password', 'adminPassword', $GLOBALS['strAdminPassword'], ['class' => 'medium zxcvbn-check', 'autocomplete' => 'new-password']);
        $this->addElement('password', 'adminPassword2', $GLOBALS['strRepeatPassword'], ['class' => 'medium', 'autocomplete' => 'new-password']);
        $this->addElement('text', 'adminEmail', $GLOBALS['strAdministratorEmail'], ['class' => 'medium']);
        $this->addElement('select', 'adminLanguage', $GLOBALS['strLanguage'], $this->aLanguages, ['class' => 'small']);
        $this->addElement('select', 'prefsTimezone', $GLOBALS['strTimezone'], $this->aTimezones, ['class' => 'medium']);
        $this->addElement('static', 'moreFields', '<a href="#" id="showMoreFields">' . $GLOBALS['strConfigSeeMoreFields'] . '</a>');

        //Form validation rules
        $this->addRequiredRule('adminName', $GLOBALS['strAdminUsername']);
        $this->addRequiredRule('adminPassword', $GLOBALS['strAdminPassword']);
        $this->addRequiredRule('adminPassword2', $GLOBALS['strRepeatPassword']);
        $this->addRequiredRule('adminEmail', $GLOBALS['strAdministratorEmail']);
        $this->addRequiredRule('adminLanguage', $GLOBALS['strLanguage']);
        $this->addRequiredRule('prefsTimezone', $GLOBALS['strTimezone']);

        $this->addRule(['adminPassword2', 'adminPassword'], $GLOBALS['strNotSamePasswords'], 'compare');
        $this->addRule('adminEmail', $GLOBALS['strEmailField'], 'email');

        if (!empty($aConf['security']['passwordMinLength'])) {
            $this->addRule('adminPassword', $GLOBALS['strPasswordTooShort'], 'minlength', $aConf['security']['passwordMinLength']);
        }
    }


    protected function buildPathsConfigurationSection()
    {
        $http = "http://";
        $https = "https://";
        $http_s = "http(s)://";

        //build form
        $this->addElement('header', 'h_paths', $GLOBALS['strConfigurationSettings']);
        $this->addElement(
            'text',
            'webpathAdmin',
            $GLOBALS['strWebPathSimple'],
            ['prefix' => $http_s, 'class' => 'large']
        );
        $this->addElement(
            'text',
            'webpathDelivery',
            $GLOBALS['strDeliveryPath'],
            ['prefix' => $http, 'class' => 'large']
        );
        $this->addElement(
            'text',
            'webpathImages',
            $GLOBALS['strImagePath'],
            ['prefix' => $http, 'class' => 'large']
        );
        $this->addElement(
            'text',
            'webpathDeliverySSL',
            $GLOBALS['strDeliverySslPath'],
            ['prefix' => $https, 'class' => 'large']
        );
        $this->addElement(
            'text',
            'webpathImagesSSL',
            $GLOBALS['strImageSslPath'],
            ['prefix' => $https, 'class' => 'large']
        );
        $this->addElement(
            'text',
            'storeWebDir',
            $GLOBALS['strImageStore'],
            ['class' => 'large']
        );

        //Form validation rules
        $this->addRequiredRule('webpathAdmin', $GLOBALS['strWebPathSimple']);
        $this->addRequiredRule('webpathDelivery', $GLOBALS['strDeliveryPath']);
        $this->addRequiredRule('webpathImages', $GLOBALS['strImagePath']);
        $this->addRequiredRule('webpathDeliverySSL', $GLOBALS['strDeliverySslPath']);
        $this->addRequiredRule('webpathImagesSSL', $GLOBALS['strImageSslPath']);
        $this->addRequiredRule('storeWebDir', $GLOBALS['strImageStore']);


        $this->addDecorator('h_paths', 'tag', ['tag' => 'div',
            'attributes' => ['id' => 'moreFields', 'class' => 'hide']]);
    }


    protected function buildPreviousPathSection()
    {
        //build form
        $this->addElement('header', 'h_old_path', $GLOBALS['strPreviousInstallTitle']);
        $this->addElement(
            'text',
            'previousPath',
            $GLOBALS['strPathToPrevious'],
            ['class' => 'medium']
        );
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
        $aConfig = [];
        $aConfig['webpath']['admin'] = $aFields['webpathAdmin'];
        $aConfig['webpath']['delivery'] = $aFields['webpathDelivery'];
        $aConfig['webpath']['images'] = $aFields['webpathImages'];
        $aConfig['webpath']['deliverySSL'] = $aFields['webpathDeliverySSL'];
        $aConfig['webpath']['imagesSSL'] = $aFields['webpathImagesSSL'];
        $aConfig['store']['webDir'] = $aFields['storeWebDir'];
        $aConfig['previousInstallationPath'] = $aFields['previousPath'];

        $aAdmin = [];
        $aAdmin['name'] = $aFields['adminName'];
        $aAdmin['pword'] = $aFields['adminPassword'];
        $aAdmin['pword2'] = $aFields['adminPassword2'];
        $aAdmin['email'] = $aFields['adminEmail'];
        $aAdmin['language'] = $aFields['adminLanguage'];

        $aPrefs = [];
        $aPrefs['timezone'] = $aFields['prefsTimezone'];


        return ['config' => $aConfig, 'admin' => $aAdmin, 'prefs' => $aPrefs];
    }


    /**
     * Populates form with values obtained from $oUpgrader->aDsn database config
     * @param $aDbConfig $oUpgrader->aDsn data
     */
    public function populateForm($aConfig)
    {
        $aFields = [];

        $aPathConfig = $aConfig['config'];

        //config part
        $aFields = [];
        $aFields['webpathAdmin'] = $aPathConfig['webpath']['admin'];
        $aFields['webpathDelivery'] = $aPathConfig['webpath']['delivery'];
        $aFields['webpathImages'] = $aPathConfig['webpath']['images'];
        $aFields['webpathDeliverySSL'] = $aPathConfig['webpath']['deliverySSL'];
        $aFields['webpathImagesSSL'] = $aPathConfig['webpath']['imagesSSL'];
        $aFields['storeWebDir'] = $aPathConfig['store']['webDir'];
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
