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

require_once 'XML/Parser.php';

/**
 * Parses an XML plugin install file
 *
 * @package OpenXPlugin
 */
class OX_ParserBase extends XML_Parser
{
    public $aPlugin = [];
    public $aInstall = [];
    public $aUninstall = [];
    public $aConf = [];
    public $aSettings = [];
    public $aPrefs = [];
    public $aFiles = [];
    public $aFile = [];
    public $aSyscheck = [];
    public $aDbms = [];
    public $aPhp = [];
    public $aDepends = [];

    public $aData = [];

    public $aAllFiles = [];

    public $elements = [];
    public $element = '';
    public $count = 0;
    public $error;

    public function __construct()
    {
        // force ISO-8859-1 due to different defaults for PHP4 and PHP5
        // todo: this probably needs to be investigated some more andcleaned up
        parent::__construct('ISO-8859-1');
    }

    private function _initArray()
    {
        $this->aSettings = [];
        $this->aPrefs = [];
        $this->aFiles = [];
        $this->aFile = [];
        $this->aDbms = [];
        $this->aPhp = [];
        $this->aDepends = [];
        $this->aConf = [
                              'option' => '',
                              'settings' => [],
                              'preferences' => [],
                               ];
        $this->aSyscheck = [
                              'php' => [],
                              'dbms' => [],
                              'depends' => [],
                               ];
        $this->aInstall = [
                                'conf' => [],
                                'syscheck' => [],
                                'files' => [],
                                'prescript' => '',
                                'postscript' => '',
                                ];
        $this->aUninstall = [
                                'prescript' => '',
                                'postscript' => '',
                                ];
        $this->aPlugin = [
                             'name' => '',
                             'displayname' => '',
                             'creationdate' => '',
                             'author' => '',
                             'authoremail' => '',
                             'authorurl' => '',
                             'license' => '',
                             'description' => '',
                             'version' => '',
                             'oxversion' => '',
                             'extends' => '',
                             'install' => [],
                             'upgrade' => [],
                             'uninstall' => [],
                             ];
    }

    private function _assignArray()
    {
        $this->aConf['settings'] = $this->aSettings;
        $this->aConf['preferences'] = $this->aPrefs;

        $this->aSyscheck['dbms'] = $this->aDbms;
        $this->aSyscheck['php'] = $this->aPhp;
        $this->aSyscheck['depends'] = $this->aDepends;

        $this->aInstall['conf'] = $this->aConf;
        $this->aInstall['syscheck'] = $this->aSyscheck;
        $this->aInstall['files'] = $this->aFiles;
        $this->aPlugin['install'] = $this->aInstall;
        $this->aPlugin['uninstall'] = $this->aUninstall;
        $this->aPlugin['upgrade'] = @$this->aUpgrade;
        $this->aPlugin['allfiles'] = $this->aAllFiles;
    }

    public function startHandler($xp, $element, $attribs)
    {
        $this->elements[$this->count++] = strtolower($element);
        $this->element = implode('-', $this->elements);

        switch ($this->element) {
            case 'plugin':
                $this->_initArray();
                break;

            case 'plugin-install-files-file':
                $this->aData = [];
                foreach ($attribs as $k => $v) {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-syscheck-depends-plugin':
                $this->aData = [];
                foreach ($attribs as $k => $v) {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-syscheck-dbms':
                $this->aData = [];
                break;
            case 'plugin-install-syscheck-php-setting':
                $this->aData = [];
                foreach ($attribs as $k => $v) {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
        }
    }

    public function endHandler($xp, $element)
    {
        switch ($this->element) {
            case 'plugin':
                $this->_assignArray();
                break;
            case 'plugin-install-files-file':
                $this->aFiles[] = $this->aData;
                $this->aAllFiles[] = $this->aData;
                break;
            case 'plugin-install-syscheck-depends-plugin':
                $this->aDepends[] = $this->aData;
                break;
            case 'plugin-install-syscheck-dbms':
                $this->aDbms[] = $this->aData;
                break;
            case 'plugin-install-syscheck-php-setting':
                $this->aPhp[] = $this->aData;
                break;
            case 'plugin-install-prescript':
                $this->aAllFiles[] = ['name' => $this->aInstall['prescript'], 'path' => OX_PLUGIN_GROUPPATH . '/etc/'];
                break;
            case 'plugin-install-postscript':
                $this->aAllFiles[] = ['name' => $this->aInstall['postscript'], 'path' => OX_PLUGIN_GROUPPATH . '/etc/'];
                break;
            case 'plugin-uninstall-prescript':
                $this->aAllFiles[] = ['name' => $this->aUninstall['prescript'], 'path' => OX_PLUGIN_GROUPPATH . '/etc/'];
                break;
            case 'plugin-uninstall-postscript':
                $this->aAllFiles[] = ['name' => $this->aUninstall['postscript'], 'path' => OX_PLUGIN_GROUPPATH . '/etc/'];
                break;
        }

        unset($this->elements[--$this->count]);
        $this->element = implode('-', $this->elements);
    }

    public function cdataHandler($xp, $data)
    {
        switch ($this->element) {
            case 'plugin-install-files-file':
                @$this->aData['name'] .= $data;
                break;
            case 'plugin-install-syscheck-depends-plugin':
                @$this->aData['name'] .= $data;
                break;
            case 'plugin-install-syscheck-php-setting':
                @$this->aData['value'] .= $data;
                break;
            case 'plugin-install-syscheck-dbms-name':
                @$this->aData['name'] .= $data;
                break;
            case 'plugin-install-syscheck-dbms-supported':
                @$this->aData['supported'] .= $data;
                break;
            case 'plugin-install-syscheck-dbms-version':
                @$this->aData['version'] .= $data;
                break;
            case 'plugin-install-syscheck-dbms-engine':
                @$this->aData['engine'] .= $data;
                break;
            case 'plugin-install-syscheck-dbms-grant':
                @$this->aData['grant'] .= $data;
                break;
            case 'plugin-install-prescript':
                @$this->aInstall['prescript'] .= $data;
                break;
            case 'plugin-install-postscript':
                @$this->aInstall['postscript'] .= $data;
                break;
            case 'plugin-uninstall-prescript':
                @$this->aUninstall['prescript'] .= $data;
                break;
            case 'plugin-uninstall-postscript':
                @$this->aUninstall['postscript'] .= $data;
                break;
            case 'plugin-version':
                // Fix potential issues with lowercase RC's
                @$this->aPlugin['version'] = preg_replace('/rc([0-9]+)$/', 'RC$1', $data);
                break;
            case 'plugin-name':
            case 'plugin-displayname':
            case 'plugin-creationdate':
            case 'plugin-author':
            case 'plugin-authoremail':
            case 'plugin-authorurl':
            case 'plugin-license':
            case 'plugin-oxversion':
            case 'plugin-extends':
            case 'plugin-description':
                @$this->aPlugin[str_replace('plugin-', '', $this->element)] .= $data;
                break;
        }
    }

    public function raiseInstanceError($msg = null, $xmlecode = 0, $xp = null, $ecode = OX_PLUGIN_ERROR_PARSE)
    {
        if (is_null($this->error)) {
            $error = '';
            if (is_resource($msg)) {
                $error .= 'Parser error: ' . xml_error_string(xml_get_error_code($msg));
                $xp = $msg;
            } else {
                $error .= 'Parser error: ' . $msg;
                if (!is_resource($xp)) {
                    $xp = $this->parser;
                }
            }
            if (is_resource($xp)) {
                $byte = @xml_get_current_byte_index($xp);
                $line = @xml_get_current_line_number($xp);
                $column = @xml_get_current_column_number($xp);
                $error .= " - Byte: $byte; Line: $line; Col: $column";
            }
            $error .= "\n";
            $mode = 0;
            $options = 0;
            $userinfo = '';

            $this->error = PEAR::raiseError($error, $xmlecode, $mode, $options, $userinfo);
            return $this->error;
        }
        return $this->error;
    }
}
