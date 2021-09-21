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
class OX_ParserPlugin extends OX_ParserBase
{
    public $aContents = [];

    public function startHandler($xp, $element, $attribs)
    {
        parent::startHandler($xp, $element, $attribs);

        switch ($this->element) {
            case 'plugin-install-contents-group':
                $this->aData = [];
                foreach ($attribs as $k => $v) {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-contents':
                $this->aContents = [];
                break;
        }
    }

    public function endHandler($xp, $element)
    {
        switch ($this->element) {
            case 'plugin':
                $this->aInstall['contents'] = $this->aContents;
                break;
        }

        parent::endHandler($xp, $element);
    }

    public function cdataHandler($xp, $data)
    {
        parent::cdataHandler($xp, $data);

        switch ($this->element) {
            case 'plugin-name':
                $this->aAllFiles[] = ['name' => $data . '.xml', 'path' => OX_PLUGIN_PLUGINPATH];
                break;
            case 'plugin-install-contents-group':
                $this->aContents[$data] = $this->aData;
                break;
        }
    }
}
