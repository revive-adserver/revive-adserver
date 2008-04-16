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

/**
 *
 * @package    Max
 * @subpackage SimulationSuite
 * @author
 */

require_once '../../../init.php';
require_once './init.php';

$file = $_GET['file'];
$type = $_GET['type'];

function checkVersion($id=0)
{
    require_once ('XML/RPC.php' );

    global $XML_RPC_String, $XML_RPC_Boolean;
    global $XML_RPC_Array, $XML_RPC_Struct;
    global $XML_RPC_Int;

    // Prepare variables
    $aParams = array(
        'changeset_id'      => $id,
    );

    // Create the XML-RPC message
    $message = new XML_RPC_Message('OXUPMS.checkID', array(
        XML_RPC_encode($aParams)
    ));

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client('/upms/xmlrpc.php','localhost', '80');
    $client->debug = 0;

    // Send the XML-RPC message to the server
    $response = $client->send($message, 60, 'http');

    // Was the response OK?
    if ($response && $response->faultCode() == 0) {
        $response = XML_RPC_decode($response->value());

        return $response;
    }

    return false;
}

function registerVersion($id=0, $name='unknown', $comments='')
{
    require_once ('XML/RPC.php' );

    global $XML_RPC_String, $XML_RPC_Boolean;
    global $XML_RPC_Array, $XML_RPC_Struct;
    global $XML_RPC_Int;

    // Prepare variables
    $aParams = array(
        'user_name'         => $name,
        'changeset_id'      => $id,
        'comments'          => $comments,
    );

    // Create the XML-RPC message
    $message = new XML_RPC_Message('OXUPMS.registerID', array(
        XML_RPC_encode($aParams)
    ));

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client('/upms/xmlrpc.php','localhost', '80');
    $client->debug = 0;

    // Send the XML-RPC message to the server
    $response = $client->send($message, 60, 'http');

    // Was the response OK?
    if ($response && $response->faultCode() == 0) {
        $response = XML_RPC_decode($response->value());

        return $response;
    }

    return array(
        'id'        => 'unregistered',
        'user'      => 'unregistered',
        'comments'  => 'unregistered',
    );
}

function getNextVersion()
{
    require_once ('XML/RPC.php' );

    global $XML_RPC_String, $XML_RPC_Boolean;
    global $XML_RPC_Array, $XML_RPC_Struct;
    global $XML_RPC_Int;

    // Create the XML-RPC message
    $message = new XML_RPC_Message('OXUPMS.getNextID');

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client('/upms/xmlrpc.php','localhost', '80');
    $client->debug = 0;

    // Send the XML-RPC message to the server
    $response = $client->send($message, 60, 'http');

    // Was the response OK?
    if ($response && $response->faultCode() == 0) {
        $result = XML_RPC_decode($response->value());

        return $result;
    }
    else if ($response->faultCode() > 0)
    {
        $result = $response->faultString();
    }
    return $result;
    //return 'unknown';
}

/*function setupData()
{
    $aList = get_package_array();
    $aChangesets = $aList['changeset'];
    $user   = 'Unkown User';
    //$schema = 'tables_core'; schema column default
    $query = 'INSERT INTO changesets (id, user, comments) VALUES ';
    foreach ($aChangesets AS $k => $file)
    {
        $pattern = '/changes_tables_core_(?P<version>[\d]+)\.xml/';
        if (preg_match($pattern, $file, $aMatches))
        {
            $version = $aMatches['version'];
            $aChanges = getChangesetDefinition($file);
            $comments = $aChanges['comments'] ? mysql_escape_string(html_entity_decode($aChanges['comments'],ENT_QUOTES)) : '-';
            $query.= "({$version}, '{$user}', '{$comments}'),";
            $aChangesets[$k] = $version;
        }
    }
    return $query;
}*/

function getChangesetDefinition($file_changes)
{
    if (!file_exists(MAX_PATH.'/etc/changes/'.$file_changes))
    {
        return false;
    }
    require_once MAX_PATH . '/lib/OA/DB/XmlCache.php';
    $oCache = new OA_DB_XmlCache();
    $aChanges = $oCache->get($file_changes);

    if (!$aChanges)
    {
        require_once MAX_PATH.'/lib/OA/DB.php';
        require_once 'MDB2/Schema.php';
        $oSchema  =&  MDB2_Schema::factory(OA_DB::singleton());
        $aChanges = $oSchema->parseChangesetDefinitionFile(MAX_PATH.'/etc/changes/'.$file_changes);

        if (PEAR::isError($aChanges, 'failed to parse changeset ('.$file_changes.')'))
        {
            return false;
        }
    }
    return $aChanges;
}

if ($type == 'changeset')
{
    $name   = 'Unkown User';
    $schema = 'tables_core';

    if ($file == 'new')
    {
        $id = getNextVersion();
        if (!$id)
        {
            $aErrors[] = $id;
        }

    }
    else if ($file == 'reg')
    {
        $id = getNextVersion();
        if (!$id)
        {
            $aErrors[] = $id;
        }

        $aNew  = checkVersion($id);
        if (is_array($aNew) && array_key_exists($id,$aNew))
        {
            $aErrors[] = 'Schema version '.$id.' was registered by '.$aNew[$id]['user'].' on '.$aNew[$id]['registered'];
        }
        else
        {
            $comments   = 'some comments about schema version '.$id;

            $aNew       = registerVersion($id, $name, $comments);
            if (!is_array($aNew))
            {
                $aErrors[] = $aNew;
            }
        }
    }
    else
    {
        $aChanges = getChangesetDefinition($file);

        $id     = $aChanges['version'];

        $aFile  = checkVersion($id);
        if (!is_array($aFile))
        {
            $aErrors[] = $aFile;
        }
    }
}
else
{
    // one-off job to parse changesets and populate database
    //setupData();
}

include 'templates/body_action.html';


?>
