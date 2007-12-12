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

require_once MAX_PATH . '/lib/OA/Permission/Gacl.php';

/**
 * class to insert gacl permissions into clean database
 * uses automatic acls generation script: www/devel/gacl/export_acls.php
 */
class OA_GaclPermissions
{
    /**
     * Versions required by GACL
     * @static
     */
    function insertVersion()
    {
        $db = &OA_DB::singleton();
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'].'gacl_';
        $db->query("DELETE FROM ".$prefix."phpgacl");
        $db->query("INSERT INTO ".$prefix."phpgacl (name,value) VALUES ('version','3.3.7')");
        $db->query("INSERT INTO ".$prefix."phpgacl (name,value) VALUES ('schema_version','2.1')");
    }

    /**
     * This list is gerenated by export_acls.php script
     * which you could find in www/devel/gacl/ folder
     */
    function insert()
    {
        OA_GaclPermissions::insertVersion();
        
        $oGacl = OA_Permission_Gacl::factory();
        
        $oGacl->add_object_section('Users', 'USERS', 0, 0, 'ARO');
        
        $oGacl->add_object_section('System', 'system', 0, 0, 'ACL');
        $oGacl->add_object_section('User', 'user', 0, 0, 'ACL');

        $oGacl->add_object_section('Accounts', 'ACCOUNTS', 0, 0, 'AXO');

        $rootGid    = $oGacl->add_group('ROOT', 'Root', 0, 'AXO');
        $adminGid   = $oGacl->add_group('ADMIN_ACCOUNTS', 'Admin accounts', $rootGid, 'AXO');
        $managerGid = $oGacl->add_group('MANAGER_ACCOUNTS', 'Manager accounts', $adminGid, 'AXO');

        $aAcoSections = array(
            'ACCOUNT' => array(
                'name' => 'Account',
                'children' => array(
                    'ACCESS' => 'Access',
                )
            ),
            'BANNER' => array(
                'name' => 'Banner',
                'children' => array(
                    'ACTIVATE'      => 'Activate',
                    'DEACTIVATE'    => 'Deactivate',
                    'ADD'           => 'Add',
                    'EDIT'          => 'Edit',
                )
            ),
            'ZONE' => array(
                'name' => 'Zone',
                'children' => array(
                    'ADD'           => 'Add',
                    'DELETE'        => 'Delete',
                    'EDIT'          => 'Edit',
                    'INVOCATION'    => 'Generate invocation code',
                    'LINK'          => 'Link banners to a zone',
                )
            ),
        );
        
        foreach ($aAcoSections as $sectionValue => $aSection) {
            $oGacl->add_object_section($aSection['name'], $sectionValue, 0, 0, 'ACO');
            foreach ($aSection['children'] as $acoValue => $acoName) {
                $oGacl->add_object($sectionValue, $acoName, $acoValue, 0, 0, 'ACO');
            }
        }

        return true;
    }

}

?>