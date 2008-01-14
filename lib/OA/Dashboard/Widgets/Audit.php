<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/OA/Dll/Audit.php';

/**
 * A dashboard widget to diplay an RSS feed of the Openads Blog
 *
 */
class OA_Dashboard_Widget_Audit extends OA_Dashboard_Widget
{
    var $periodPreset   = 'all_events';

    //  paging related input variables
    var $listorder      = 'updated';
    var $orderdirection = 'up';
    var $setPerPage     = 6;
    var $startRecord    = 0;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_BlogFeed
     */
    function OA_Dashboard_Widget_Audit($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);

        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->oTpl = new OA_Admin_Template('dashboard/audit.html');

        $this->oTpl->setCacheId($this->title);
        $this->oTpl->setCacheLifetime(new Date_Span('0-1-0-0'));

    }

    function display()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        if (!$conf['audit']['enabled']) {
            $this->oTpl->assign('screen',       'disabled');
            $this->oTpl->assign('siteTitle',    $GLOBALS['strAuditTrailSetup']);
            $this->oTpl->assign('siteUrl',      MAX::constructUrl(MAX_URL_ADMIN, 'account-settings-debug.php'));
        } elseif ($conf['audit']['enabled']) {

            if (!$this->oTpl->is_cached()) {
                $advertiserId   = MAX_getStoredValue('advertiserId',    0);

                list($aNow['year'], $aNow['month'], $aNow['day']) = explode('-', OA::getNow('Y-m-d'));
                $startDate      = OA::getNow('Y-m-d');
                $endDate        = date('Y-m-d', mktime(0, 0, 0, $aNow['month'], $aNow['day']+7, $aNow['year']));


                $aParams = array(
                    'advertiser_id' => $advertiserId,
                    'order'         => $this->orderdirection,
                    'listorder'     => $this->listorder,
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                    'perPage'       => $this->setPerPage,
                    'startRecord'   => $this->startRecord,
                );

                $oAuditLog = & new OA_Dll_Audit();
                $aAuditData = $oAuditLog->getAuditLog($aParams);
                foreach ($aAuditData as $key => $aValue) {
                    $str = "{$aValue['username']} has {$aValue['action']} {$aValue['context']}";
                    if (!empty($aValue['contextid'])) {
                        $str .= " ({$aValue['contextid']})";
                    }
                    if (!empty($aValue['parentcontext'])) {
                        $str .= " for {$aValue['parentcontext']} ({$aValue['parentcontextid']})";
                    }
                    if (!empty($aValue['hasChildren'])) {
                        $str .= ' and additional items';
                    }
                    $aAuditData[$key]['desc'] = (strlen($str) > 30) ? substr($str, 0, 30) . '...' : $str;
                }
                if (count($aAuditData) == 0) {
                    $this->oTpl->assign('noData',   $GLOBALS['strAuditNoData']);
                }
                $this->oTpl->assign('screen',       'enabled');
                $this->oTpl->assign('aAuditData',   $aAuditData);
                $this->oTpl->assign('siteUrl',      MAX::constructUrl(MAX_URL_ADMIN, 'userlog-index.php'));
                $this->oTpl->assign('siteTitle',    $GLOBALS['strAuditTrailGoTo']);
            }
        }
        $this->oTpl->display();
    }
}

?>