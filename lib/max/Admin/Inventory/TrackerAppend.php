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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/Inventory/Trackers.php';

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once OX_PATH . '/lib/OX.php';
require_once LIB_PATH . '/Admin/Redirect.php';
require_once OX_PATH . '/lib/pear/HTML/Template/Flexy.php';



/**
 * A class for determining the available geotargeting modes.
 *
 * @package    Max
 */
class MAX_Admin_Inventory_TrackerAppend
{
    /* @var MAX_Dal_TrackerTags */
    public $_dal;

    public $_cycle = 0;

    public $advertiser_id;
    public $tracker_id;
    public $codes;
    public $showReminder;
    public $assetPath;

    /**
     * PHP5-style constructor
     */
    public function __construct()
    {
        $this->_useDefaultDal();

        $this->advertiser_id = MAX_getValue('clientid', 0);
        $this->tracker_id = MAX_getValue('trackerid', 0);
        $this->assetPath = OX::assetPath();
        $this->showReminder = false;
    }

    public function _useDefaultDal()
    {
        $oServiceLocator = OA_ServiceLocator::instance();
        $dal = &$oServiceLocator->get('MAX_Dal_Inventory_Trackers');
        if (!$dal) {
            $dal = new MAX_Dal_Inventory_Trackers();
        }
        $this->_dal = &$dal;
    }

    public function cycleRow($class)
    {
        return trim($class . (($this->_cycle++ % 2) ? ' light' : ' dark'));
    }

    public function getPausedCodes()
    {
        $paused = [];
        foreach ($this->codes as $k => $v) {
            if ($v['paused']) {
                $paused[] = $k;
            }
        }

        return join(',', $paused);
    }

    public function handlePost($vars)
    {
        $codes = [];

        if (isset($vars['tag']) && is_array($vars['tag'])) {
            foreach ($vars['tag'] as $k => $v) {
                $codes[$k] = ['tagcode' => stripslashes($v), 'paused' => false];
                $codes[$k]['autotrack'] = isset($vars['autotrack'][$k]);
            }
        }

        if (isset($vars['t_paused'])) {
            foreach (explode(',', $vars['t_paused']) as $k) {
                if (isset($codes[$k])) {
                    $codes[$k]['paused'] = true;
                }
            }
        }

        if (isset($vars['t_action'])) {
            switch ($vars['t_action']) {
                case 'new':
                    $codes[] = ['tagcode' => '', 'paused' => false];
                    break;

                case 'del':
                    if (isset($vars['t_id']) && isset($codes[$vars['t_id']])) {
                        unset($codes[$vars['t_id']]);
                    }
                    break;

                case 'up':
                    if (isset($vars['t_id']) && isset($codes[$vars['t_id']]) && isset($codes[$vars['t_id'] - 1])) {
                        $tmp = $codes[$vars['t_id']];
                        $codes[$vars['t_id']] = $codes[$vars['t_id'] - 1];
                        $codes[$vars['t_id'] - 1] = $tmp;
                    }
                    break;

                case 'down':
                    if (isset($vars['t_id']) && isset($codes[$vars['t_id']]) && isset($codes[$vars['t_id'] + 1])) {
                        $tmp = $codes[$vars['t_id']];
                        $codes[$vars['t_id']] = $codes[$vars['t_id'] + 1];
                        $codes[$vars['t_id'] + 1] = $tmp;
                    }
                    break;

                case 'pause':
                case 'restart':
                    if (isset($vars['t_id']) && isset($codes[$vars['t_id']])) {
                        $codes[$vars['t_id']]['paused'] = $vars['t_action'] == 'pause';
                    }
                    break;
            }
        }

        if (isset($vars['save'])) {
            $this->_dal->setAppendCodes($this->tracker_id, $codes);

            // Queue confirmation message
            $doTrackers = OA_Dal::factoryDO('trackers');
            $doTrackers->get($this->tracker_id);

            $translation = new OX_Translation();
            $translated_message = $translation->translate($GLOBALS['strTrackerAppendHasBeenUpdated'], [
                MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=" . $this->advertiser_id . "&trackerid=" . $this->tracker_id),
                htmlspecialchars($doTrackers->trackername)
            ]);
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            OX_Admin_Redirect::redirect("tracker-append.php?clientid={$this->advertiser_id}&trackerid={$this->tracker_id}");
        } else {
            $this->codes = $codes;
            $this->showReminder = true;
        }
    }

    public function handleGet()
    {
        if (is_null($this->codes)) {
            $this->codes = $this->_dal->getAppendCodes($this->tracker_id);
        }
    }

    public function display()
    {
        $output = new HTML_Template_Flexy([
            'templateDir' => MAX_PATH . '/lib/max/Admin/Inventory/themes',
            'compileDir' => MAX_PATH . '/var/templates_compiled',
            'flexyIgnore' => true
        ]);

        // Load token now
        $this->csrf_token = phpAds_SessionGetToken();

        $codes = $this->codes;
        $this->codes = [];
        if (is_array($codes)) {
            foreach ($codes as $v) {
                $k = count($this->codes);
                $v['id'] = "tag_{$k}";
                $v['name'] = "tag[{$k}]";
                $v['autotrackname'] = "autotrack[{$k}]";
                $v['autotrack'] = isset($v['autotrack']) ? $v['autotrack'] : false;
                $v['rank'] = $k + 1;
                $v['move_up'] = $k > 0;
                $v['move_down'] = $k < count($codes) - 1;
                $this->codes[] = $v;
            }
        }

        // Display page content
        $output->compile('TrackerAppend.html');
        $output->outputObject($this);
    }
}
