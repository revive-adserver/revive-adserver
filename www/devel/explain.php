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

require_once './init.php';

require_once MAX_PATH . '/lib/OA/DB.php';

function parseLogFile()
{
    $oDbh = &OA_DB::singleton();
    OA::disableErrorHandling();

    $fpsql = fopen(MAX_PATH."/var/sql.log", 'r');
    if (!$fpsql)
    {
        $aResult[]['error'] = 'unable to open file '.MAX_PATH."/var/sql.log";
        $aResult[]['error'] = 'to create '.MAX_PATH.'/var/sql.log, trigger logging by setting [debug] logSQL="select|update|insert|delete (as appropriate) in your conf file.';
        $aResult[]['error'] = 'running the devel explain utility also creates mysqlsla.log which can be fed to mysqlsla for analysis: mysqlsla --user <dbuser> --host <dbhost> --port <dbport> --te --sort e --raw mysqlsla.log > mysqlsla.txt';
        $aResult[]['error'] = 'running the devel explain utility also creates mysqlqp.log which can be fed to mysql-query-profiler for analysis: mysql-query-profiler --user <dbuser> --host <dbhost> --port <dbport> --database <dbname> mysqlqp.log > mysqlqp.txt
';

        return $aResult;
    }
    while ($v = fgets($fpsql,4096))
    {
        $aQueries[] = $v;
    }
    fclose($fpsql);

    $aQueries = array_unique($aQueries);

    if (count($aQueries) > 1)
    {
        // write a log for use by mysqlsla
        $fpsla = fopen(MAX_PATH."/var/mysqlsla.log", 'w');
        fwrite($fpsla, "USE {$oDbh->connected_database_name};\n");
        // write a log for use by mysql-query-profiler
        $fpmqp = fopen(MAX_PATH."/var/mysqlqp.log", 'w');

        foreach ($aQueries AS $k => $v)
        {
            if (substr_count($v, 'tmp_')==0)
            {
                $i = preg_match('/((\[(?P<type>[\w]+)\])(?P<query>[\w\W\s]+))/',$v,$aMatches);
                if ($i)
                {
                    $type = $aMatches['type'];
                    $query = trim($aMatches['query']);
                    $aResult[$k]['query']  = $query;
                    if ($type=='prepare' || (strpos($query,'PREPARE MDB2_STATEMENT')===0))
                    {
                        $aResult[$k]['error']  = 'cannot execute statement: '.$query;
                    }
                    else
                    {
                        $result = $oDbh->getAssoc('EXPLAIN '.$query);
                        if (!PEAR::isError($result))
                        {
                            $aResult[$k]['result'] = $result;
                            fwrite($fpsla, $query."\n");
                            fwrite($fpmqp, $query."\n\n");
                        }
                        else
                        {
                            //$aResult[$k]['error']  = $result->getUserInfo();
                            $aResult[$k]['error']  = 'failed to explain statement: '.$query;
                        }
                    }
                }
            }
        }
        fclose($fpsla);
        fclose($fpmqp);

        $aConf = $GLOBALS['_MAX']['CONF']['database'];

        $cmd = "sudo /usr/local/sbin/mysqlsla --user {$aConf['username']} --host {$aConf['host']} --port {$aConf['port']} --time-each-query --sort e --top 50 --flush-qc --avg 10 --raw mysqlsla.log > mysqlsla.txt";
        $fpsla = fopen(MAX_PATH."/var/mysqlslarun", 'w');
        fwrite($fpsla, $cmd);
        fclose($fpsla);

        $cmd = "mysql-query-profiler --user {$aConf['username']} --host {$aConf['host']} --port {$aConf['port']} --database {$aConf['name']} mysqlqp.log > mysqlqp.txt";
        $fpmqp = fopen(MAX_PATH."/var/mysqlqprun", 'w');
        fwrite($fpmqp, $cmd);
        fclose($fpmqp);

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
include 'templates/explain.html';



?>
