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
 * Common UserAccess related UI methods
 *
 */
class OA_Admin_UI_UserAccess
{
    function assignUserStartTemplateVariables(&$oTpl)
    {
        $oTpl->assign('method', 'GET');
        
        // TODOHOSTED: will need to know whether we're hosted or downloaded
        $HOSTED = false; 
        $oTpl->assign('hosted', $HOSTED);
        
        if ($HOSTED) {
           $oTpl->assign('fields', array(
               array(
                   'title'     => "E-mail",
                   'fields'    => array(
                       array(
                           'name'      => 'email',
                           'label'     => $GLOBALS['strEmailToLink'],
                           'value'     => '',
                           'id'        => 'user-key'
                       )
                   )
               )
           ));
        }
        else
        {
           $oTpl->assign('fields', array(
               array(
                   'title'     => $strUsername,
                   'fields'    => array(
                       array(
                           'name'      => 'login',
                           'label'     => $GLOBALS['strUsernameToLink'],
                           'value'     => '',
                           'id'        => 'user-key'
                       ),
                   )
               ),
           ));
        }
    }
    
    function getUserDetailsFields($affiliate)
    {
        
        if ($HOSTED) {
           $userDetailsFields[] = array(
                          'name'      => 'email_address',
                          'label'     => $GLOBALS['strEMail'],
                          'value'     => 'test@test.com', // TODO: put e-mail here
                          'freezed'   => true
                      );
        
           if ($existingUser) {
              $userDetailsFields[] = array(
                           'type'      => 'custom',
                           'template'  => 'link',
                           'label'     => $GLOBALS['strPwdRecReset'],
                           'href'      => 'user-password-reset.php', // TODO: put the actual password resetting script here
                           'text'      => $GLOBALS['strPwdRecResetPwdThisUser']
                       );
           }
           else {
              $userDetailsFields[] = array(
                           'name'      => 'contact',
                           'label'     => $GLOBALS['strContactName'],
                           'value'     => $affiliate['contact']
                       );
           }
        }
        else {
           $userDetailsFields[] = array(
                           'name'      => 'login',
                           'label'     => $GLOBALS['strUsername'],
                           'value'     => $affiliate['username'],
                           'freezed'   => !empty($affiliate['user_id'])
                       );
           $userDetailsFields[] = array(
                           'name'      => 'passwd',
                           'label'     => $GLOBALS['strPassword'],
                           'value'     => '',
                           'hidden'   => !empty($affiliate['user_id'])
                       );
           $userDetailsFields[] = array(
                           'name'      => 'contact_name',
                           'label'     => $GLOBALS['strContactName'],
                           'value'     => $affiliate['contact_name'],
                       );
           $userDetailsFields[] = array(
                           'name'      => 'email_address',
                           'label'     => $GLOBALS['strEMail'],
                           'value'     => $affiliate['email_address']
                       );
        }
        return $userDetailsFields;
    }
    
}

?>