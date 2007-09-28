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
$Id $
*/

require_once './init.php';

require_once MAX_PATH . '/lib/OA/DB.php';

function parseLogFile()
{
    $oDbh = &OA_DB::singleton();
    OA::disableErrorHandling();

    $data = file_get_contents(MAX_PATH."/var/sql.log");
    $i = preg_match_all('|<<([\s\W\w]+)>>|U',$data, $aMatches);
    $data = null;

    if ($i > 1)
    {
        $aQueries = array_unique($aMatches[1]);
        $aMatches = null;
        $fp = fopen(MAX_PATH."/var/mysqsla.log", 'w');
        fwrite($fp, "USE {$oDbh->connected_database_name};\n");

        foreach ($aQueries AS $k => $v)
        {
            if (substr_count($v, 'tmp_')==0)
            {
                $query = trim($v);
                $result = $oDbh->getAssoc('EXPLAIN '.$query);
                if (!PEAR::isError($result))
                {
                    $aResult[$k]['query']  = $query;
                    $aResult[$k]['result'] = $result;
                    fwrite($fp, $query.";\n");
                }
                else
                {
                    $aResult[$k]['query']  = $query;
                    $aResult[$k]['result'][0]['table'] = '...';
                    $aResult[$k]['result'][0]['ref']   = '...';
                    $aResult[$k]['result'][0]['type']  = '...';
                    $aResult[$k]['result'][0]['rows']  = '...';
                    $aResult[$k]['result'][0]['key']   = '...';
                    $aResult[$k]['result'][0]['key_len']= '...';
                    $aResult[$k]['result'][0]['possible_keys']= '...';
                    $aResult[$k]['result'][0]['select_type']= '...';
                    $aResult[$k]['result'][0]['extra'] = '...';
                }
            }
        }
        fclose($fp);

        $aConf = $GLOBALS['_MAX']['CONF']['database'];
        $cmd = "sudo /usr/local/sbin/mysqlsla --user {$aConf['username']} --host {$aConf['host']} --port {$aConf['port']} --te --sort e --raw mysqsla.log > mysqlsla.txt";

        $fp = fopen(MAX_PATH."/var/mysqslarun", 'w');
        fwrite($fp, $cmd);
        fclose($fp);
    }
    OA::enableErrorHandling();
    return $aResult;
}

if (array_key_exists('a',$_REQUEST))
{
    if ($_REQUEST['a']=='save')
    {

    }
}
$aDisplay = parseLogFile();
include 'tpl/explain.html';



?>
