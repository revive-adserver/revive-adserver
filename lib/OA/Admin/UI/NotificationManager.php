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

class OA_Admin_UI_NotificationManager
{
    private $TYPES = ['info' => 1, 'confirm' => 2, 'warning' => 3, 'error' => 4];
    
    public function __construct()
    {
        global $session;
        if (!isset($session['notificationQueue'])) {
            $session['notificationQueue'] = [];
        }
    }
    
    /**
     * Returns all notifications queued in this seesion.
     *
     */
    public function getNotifications()
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
    public function queueNotification($text, $type = 'info', $relatedAction = null)
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

        $session['notificationQueue'][] = [
            'id' => $session['notificationId'],
            'text' => $text,
            'type' => $type,
            'relatedAction' => $relatedAction,
        ];

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
    public function removeNotifications($relatedAction)
    {
        global $session;

        if (empty($relatedAction) || !isset($session['notificationQueue'])
            || !is_array($session['notificationQueue']) || $session['notificationQueue'] === []) {
            return 0;
        }

        $aNotifications = $session['notificationQueue'];
        $aFilteredNotifications = [];

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
    
    
    public function clearNotifications()
    {
        global $session;
        
        $session['notificationQueue'] = [];
        phpAds_SessionDataStore();
    }
}
