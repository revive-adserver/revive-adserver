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
$Id:$
*/

class OA_Admin_UI_NotificationManager
{
    private $TYPES = array('info' => 1, 'confirm' => 2,'warning' => 3, 'error' => 4);
    
    function __construct()
    {
        $session['messageQueue'] = array();
    }
    
    /**
     * Returns all notifications queued in this seesion.
     *
     */
    function getNotifications()
    {
        global $session;
        
        return $session['notificationQueue'];        
    }
    
    
    /**
     * Schedules a notification to be shown on next showHeader call. 
     * Notification is shown on left side, under menu items.
     * At the moment, notifications are persistent, so scheduler must take care of removing the notification
     * when it is no longer required.
     *
     * When adding a notification an action it is related to can be specified.
     * Later, this action type can be used to access notifications in queue.
     *
     * @param string $text either Message text
     * @param string $type info, confirm, warning, error
     *  
     * @param string $relatedAction this is an optional parameter which can be used to asses the message with action it is related to
     * 
     * @return id of the queued notification
     */
    function queueNotification($text, $type = 'info', $relatedAction = null) 
    {
        global $session;

        if (!isset($session['notificationId'])) {
            $session['notificationId'] = time();
        } else {
            $session['notificationId']++;
        }
        
        if (!isset($this->TYPES[$type])) {
            $type = 'info';
        }

        $session['notificationQueue'][] = array(
            'id' => $session['notificationId'],
            'text' => $text,
            'type' => $type,
            'relatedAction' => $relatedAction,
        );

        // Force session storage
        phpAds_SessionDataStore();
        
        return $session['notificationId'];
    }


    /**
     * Removes from queue all notifications that are related to a given action. Please
     * make sure that if you intend to remove notifcations you queue them with 'relatedAction'
     * parameter set properly.
     *
     * @param string $relatedAction name of the action which notifications should be removed
     * @return number of notifications removed from queue
     */
    function removeNotifications($relatedAction)
    {
        global $session;

        if (empty($relatedAction) || !isset($session['notificationQueue'])
            || !is_array($session['notificationQueue']) || !count($session['notificationQueue'])) {
            return 0;
        }

        $aNotifications = $session['notificationQueue'];
        $aFilteredNotifications = array();

        //filter notifications out, if any
        foreach ($aNotifications as $notification) {
            if ($relatedAction != $notification['relatedAction']) {
                $aFilteredNotifications[] = $notification;
            }
        }

        //if sth was filtered save new queue
        $removedCount = count($aNotifications) - count($aFilteredNotifications);
        if ($removedCount > 0) {
            $session['notificationQueue'] = $aFilteredNotifications;
            // Force session storage
            phpAds_SessionDataStore();
        }

        return $removedCount;
    }
    
    
    function clearNotifications()
    {
        global $session;
        
        $session['notificationQueue'] = array();
        phpAds_SessionDataStore();
    }
}

?>