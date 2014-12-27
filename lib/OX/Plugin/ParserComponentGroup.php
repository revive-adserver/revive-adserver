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

require_once LIB_PATH.'/Plugin/ParserBase.php';

/**
 * Parses an XML plugin install file
 *
 * @package OpenXPlugin
 */
class OX_ParserComponentGroup extends OX_ParserBase
{

    var $aNav    = array(OA_ACCOUNT_ADMIN => array(),
                         OA_ACCOUNT_MANAGER => array(),
                         OA_ACCOUNT_ADVERTISER => array(),
                         OA_ACCOUNT_TRAFFICKER => array(),
                         'checkers' => array(),
                         );
    var $aSchema = array(
                          'mdb2schema'  => '',
                          'dboschema'   => '',
                          'dbolinks'    => '',
                          'dataobjects' => '',
                           );
    var $aData;
    var $aComponents = array();
    var $aComponent = array();

    function startHandler($xp, $element, &$attribs)
    {

        parent::startHandler($xp, $element, $attribs);

        switch ($this->element)
        {
            case 'plugin':

                $this->aNav = array(
                                     OA_ACCOUNT_ADMIN => array(),
                                     OA_ACCOUNT_MANAGER => array(),
                                     OA_ACCOUNT_ADVERTISER => array(),
                                     OA_ACCOUNT_TRAFFICKER => array(),
                                    );
                $this->aSchema  = array(
                                      'mdb2schema'  => '',
                                      'dboschema'   => '',
                                      'dbolinks'    => '',
                                      'dataobjects' => array(),
                                       );

                break;
            case 'plugin-install-navigation-admin-menu':
            case 'plugin-install-navigation-manager-menu':
            case 'plugin-install-navigation-advertiser-menu':
            case 'plugin-install-navigation-trafficker-menu':
            case 'plugin-install-navigation-checkers-checker':
            case 'plugin-install-configuration-setting':
            case 'plugin-install-configuration-preference':
                $this->aData = array();
                foreach ($attribs AS $k => $v)
                {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-configuration':
                $this->aSettings = array();
                $this->aPrefs = array();
                if (isset($attribs[strtoupper('option')]))
                {
                    $this->aConf['option'] = $attribs[strtoupper('option')];
                }
                break;
            case 'plugin-install-components-component':
                $this->aData = array();
                $this->aData['hooks'] = array();
                $this->aComponent = array();
                break;
            case 'plugin-install-components':
                $this->aComponents = array();
                break;
        }
    }

    function endHandler($xp, $element)
    {

        switch ($this->element)
        {
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
            case 'plugin':
                $this->aInstall['navigation'] = $this->aNav;
                $this->aInstall['schema']     = $this->aSchema;
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

    function cdataHandler($xp, $data)
    {
        parent::cdataHandler($xp, $data);

        switch ($this->element)
        {
            case 'plugin-install-navigation-admin-menu':
            case 'plugin-install-navigation-manager-menu':
            case 'plugin-install-navigation-advertiser-menu':
            case 'plugin-install-navigation-trafficker-menu':
            case 'plugin-install-navigation-checkers-checker':
                $this->aData['value'] = $data;
                break;
            case 'plugin-install-schema-mdb2schema':
                $this->aSchema['mdb2schema'] = $data;
                $this->aAllFiles[] = array('name'=>$data.'.xml', 'path'=>OX_PLUGIN_GROUPPATH.'/etc/');
                break;
            case 'plugin-install-schema-dboschema':
                $this->aSchema['dboschema'] = $data;
                $this->aAllFiles[] = array('name'=>$data.'.ini', 'path'=>OX_PLUGIN_GROUPPATH.'/etc/DataObjects/');
                break;
            case 'plugin-install-schema-dbolinks':
                $this->aSchema['dbolinks'] = $data;
                $this->aAllFiles[] = array('name'=>$data.'.ini', 'path'=>OX_PLUGIN_GROUPPATH.'/etc/DataObjects/');
                break;
            case 'plugin-install-schema-dataobject':
                $this->aSchema['dataobjects'][] = $data;
                $this->aAllFiles[] = array('name'=>$data, 'path'=>OX_PLUGIN_GROUPPATH.'/etc/DataObjects/');
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
                $this->aAllFiles[] = array('name'=>$data.'.xml', 'path'=>OX_PLUGIN_GROUPPATH.'/');
                break;
        }

    }
}

?>
