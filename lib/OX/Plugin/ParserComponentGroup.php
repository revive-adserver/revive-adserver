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

require_once LIB_PATH . '/Plugin/ParserBase.php';

/**
 * Parses an XML plugin install file
 *
 * @package OpenXPlugin
 */
class OX_ParserComponentGroup extends OX_ParserBase
{
    public $aNav = [OA_ACCOUNT_ADMIN => [],
                         OA_ACCOUNT_MANAGER => [],
                         OA_ACCOUNT_ADVERTISER => [],
                         OA_ACCOUNT_TRAFFICKER => [],
                         'checkers' => [],
                         ];
    public $aSchema = [
                          'mdb2schema' => '',
                          'dboschema' => '',
                          'dbolinks' => '',
                          'dataobjects' => '',
                           ];
    public $aData;
    public $aComponents = [];
    public $aComponent = [];

    public function startHandler($xp, $element, $attribs)
    {
        parent::startHandler($xp, $element, $attribs);

        switch ($this->element) {
            case 'plugin':

                $this->aNav = [
                                     OA_ACCOUNT_ADMIN => [],
                                     OA_ACCOUNT_MANAGER => [],
                                     OA_ACCOUNT_ADVERTISER => [],
                                     OA_ACCOUNT_TRAFFICKER => [],
                                    ];
                $this->aSchema = [
                                      'mdb2schema' => '',
                                      'dboschema' => '',
                                      'dbolinks' => '',
                                      'dataobjects' => [],
                                       ];

                break;
            case 'plugin-install-navigation-admin-menu':
            case 'plugin-install-navigation-manager-menu':
            case 'plugin-install-navigation-advertiser-menu':
            case 'plugin-install-navigation-trafficker-menu':
            case 'plugin-install-navigation-checkers-checker':
            case 'plugin-install-configuration-setting':
            case 'plugin-install-configuration-preference':
                $this->aData = [];
                foreach ($attribs as $k => $v) {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-configuration':
                $this->aSettings = [];
                $this->aPrefs = [];
                if (isset($attribs[strtoupper('option')])) {
                    $this->aConf['option'] = $attribs[strtoupper('option')];
                }
                break;
            case 'plugin-install-components-component':
                $this->aData = [];
                $this->aData['hooks'] = [];
                $this->aComponent = [];
                break;
            case 'plugin-install-components':
                $this->aComponents = [];
                break;
        }
    }

    public function endHandler($xp, $element)
    {
        switch ($this->element) {
            case 'plugin-install-navigation-admin-menu':
                $this->aNav[OA_ACCOUNT_ADMIN][] = $this->aData;
                break;
            case 'plugin-install-navigation-manager-menu':
                $this->aNav[OA_ACCOUNT_MANAGER][] = $this->aData;
                break;
            case 'plugin-install-navigation-advertiser-menu':
                $this->aNav[OA_ACCOUNT_ADVERTISER][] = $this->aData;
                break;
            case 'plugin-install-navigation-trafficker-menu':
                $this->aNav[OA_ACCOUNT_TRAFFICKER][] = $this->aData;
                break;
            case 'plugin-install-navigation-checkers-checker':
                $this->aNav['checkers'][] = $this->aData;
                // no break
            case 'plugin':
                $this->aInstall['navigation'] = $this->aNav;
                $this->aInstall['schema'] = $this->aSchema;
                $this->aInstall['components'] = $this->aComponents;
                break;
            case 'plugin-install-configuration-setting':
                $this->aSettings[] = $this->aData;
                break;
            case 'plugin-install-configuration-preference':
                $this->aPrefs[] = $this->aData;
                break;
            case 'plugin-install-components-component':
                $this->aComponents[$this->aData['name']] = $this->aData;
                break;

        }

        parent::endHandler($xp, $element);
    }

    public function cdataHandler($xp, $data)
    {
        parent::cdataHandler($xp, $data);

        switch ($this->element) {
            case 'plugin-install-navigation-admin-menu':
            case 'plugin-install-navigation-manager-menu':
            case 'plugin-install-navigation-advertiser-menu':
            case 'plugin-install-navigation-trafficker-menu':
            case 'plugin-install-navigation-checkers-checker':
                $this->aData['value'] = $data;
                break;
            case 'plugin-install-schema-mdb2schema':
                $this->aSchema['mdb2schema'] = $data;
                $this->aAllFiles[] = ['name' => $data . '.xml', 'path' => OX_PLUGIN_GROUPPATH . '/etc/'];
                break;
            case 'plugin-install-schema-dboschema':
                $this->aSchema['dboschema'] = $data;
                $this->aAllFiles[] = ['name' => $data . '.ini', 'path' => OX_PLUGIN_GROUPPATH . '/etc/DataObjects/'];
                break;
            case 'plugin-install-schema-dbolinks':
                $this->aSchema['dbolinks'] = $data;
                $this->aAllFiles[] = ['name' => $data . '.ini', 'path' => OX_PLUGIN_GROUPPATH . '/etc/DataObjects/'];
                break;
            case 'plugin-install-schema-dataobject':
                $this->aSchema['dataobjects'][] = $data;
                $this->aAllFiles[] = ['name' => $data, 'path' => OX_PLUGIN_GROUPPATH . '/etc/DataObjects/'];
                break;
            case 'plugin-install-configuration-setting':
                $this->aData['value'] = $data;
                break;
            case 'plugin-install-configuration-preference':
                $this->aData['value'] = $data;
                break;
            case 'plugin-install-components-component-name':
                $this->aData['name'] = $data;
                break;
            case 'plugin-install-components-component-translations':
                $this->aData['translations'] = $data;
                break;
            case 'plugin-install-components-component-hook':
                $this->aData['hooks'][] = $data;
                break;
            case 'plugin-name':
                $this->aAllFiles[] = ['name' => $data . '.xml', 'path' => OX_PLUGIN_GROUPPATH . '/'];
                break;
        }
    }
}
