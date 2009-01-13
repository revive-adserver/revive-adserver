<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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

require_once MAX_PATH.'/lib/max/Dal/Common.php';

/**
 * Trackers DAL for OpenX
 *
 * @package OpenXDal
 * @since Openads v2.3.22-alpha - Apr 13, 2006
 * @version $Id$
 */

class MAX_Dal_Inventory_Trackers extends MAX_Dal_Common
{
    function getAppendCodes($tracker_id)
    {
        $query = "
            SELECT tracker_append_id, tagcode, rank, paused, autotrack
            FROM {$this->prefix}{$this->conf['table']['tracker_append']}
            WHERE tracker_id = ". $this->oDbh->quote($tracker_id, 'integer') ."
            ORDER BY rank";
        $res = $this->oDbh->query($query);
        while ($row = $res->fetchRow()) {
            $row['paused']    = $row['paused'] == 't';
            $row['autotrack'] = $row['autotrack'] == 't';
            $tags[$row['tracker_append_id']] = $row;
        }

        return $tags;
    }

    function setAppendCodes($tracker_id, $codes)
    {
        $tracker_id = (is_numeric($tracker_id)) ? $tracker_id : (int) $tracker_id;

        $query = "
            DELETE FROM {$this->prefix}{$this->conf['table']['tracker_append']}
            WHERE tracker_id = ". $this->oDbh->quote($tracker_id, 'integer');
        $result = $this->oDbh->exec($query);

        if (PEAR::isError($result)) {
            MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }

        $rank = 0;
        $appendcodes = array();
        $doTrackerAppend = OA_Dal::factoryDO('tracker_append');
        $doTrackerAppend->tracker_id = $tracker_id;
        foreach ($codes as $v) {
            $tagcode   = trim($v['tagcode']);
            $paused    = $v['paused'] ? 't' : 'f';
            $autotrack = $v['autotrack'] ? 't' : 'f';
            if (!strlen($tagcode)) {
                continue;
            }
            $doTA = clone($doTrackerAppend);
            $doTA->tagcode   = $tagcode;
            $doTA->paused    = $paused;
            $doTA->autotrack = $autotrack;
            $doTA->rank      = ++$rank;
            $result = $doTA->insert();
            if (empty($result)) {
                MAX::raiseError("Could not insert tracker append row", MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
            }

            $appendcodes[] = array('tagcode' => $tagcode, 'paused' => $paused, 'autotrack' => $autotrack);
        }

        $query = "
            UPDATE {$this->prefix}{$this->conf['table']['trackers']}
            SET appendcode = ". $this->oDbh->quote($this->generateAppendCode($appendcodes)) ."
            WHERE trackerid = ". $this->oDbh->quote($tracker_id);
        $result = $this->oDbh->exec($query);
        if (PEAR::isError($result)) {
            MAX::raiseError($result, MAX_ERROR_DBFAILURE, PEAR_ERROR_DIE);
        }
    }

    function generateAppendCode($codes)
    {
        $vaprefix   = $GLOBALS['_MAX']['CONF']['var']['prefix'];
        $appendcode = array();

        foreach ($codes as $v) {
            if ($v['paused'] == 'f') {
                if ($v['autotrack'] == 't') {
                    // Prepare the code for auto-tracking using the inherit technique and variable templates
                    $v['tagcode'] = preg_replace('/("\?trackerid=\d+)(&amp;r="\+{$varprefix}r\+"\'><\" \+ "\/script>")/', '$1&amp;inherit=1$2', $v['tagcode']);
                    $v['tagcode'] = preg_replace('/\{variable:(.+?)\}/', '{m3_trackervariable:$1}', $v['tagcode']);
                }

                $appendcode[] = $v['tagcode'];
            }
        }

        return join("\n", $appendcode);
    }

    function checkCompiledAppendCodes()
    {
        $query = "SELECT trackerid, trackername, clientid, appendcode FROM {$this->prefix}{$this->conf['table']['trackers']}";
        $trackers = array();
        foreach ($this->oDbh->extended->getAll($query) as $row) {
            $trackers[$row['trackerid']] = $row;
        }

        $query = "SELECT tracker_id, tagcode, rank, paused FROM {$this->prefix}{$this->conf['table']['tracker_append']} WHERE paused = 'f' ORDER BY rank";
        $codes = array();
        foreach ($this->oDbh->extended->getAll($query) as $row) {
            $codes[$row['tracker_id']][] = $row;
        }

        foreach ($trackers as $tracker_id => $tracker) {
            if (!isset($codes[$tracker_id])) {
                if (empty($tracker['appendcode'])) {
                    unset($trackers[$tracker_id]);
                } else {
                    continue;
                }
            }
            if ($tracker['appendcode'] == $this->generateAppendCode($codes[$tracker_id])) {
                unset($trackers[$tracker_id]);
            }
        }

        return $trackers;
    }

    function recompileAppendCodes($ids = null) {
        if (is_null($ids)) {
            $query = "SELECT trackerid FROM {$this->prefix}{$this->conf['table']['trackers']}";
            $ids = array();
            foreach ($this->oDbh->extended->getAll($query) as $row) {
                $ids[] = $row['trackerid'];
            }
        }

        foreach ($ids as $tracker_id) {
            $this->setAppendCodes($tracker_id, $this->getAppendCodes($tracker_id));
        }
    }
}

?>
