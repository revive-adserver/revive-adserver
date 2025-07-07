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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft'] = "left";
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#.##0;-#.##0;-";
$GLOBALS['excel_decimal_formatting'] = "#.##0,000;-#.##0,000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strWhenCheckingForUpdates'] = "Кога проверувате за ажурирања";

// Dashboard
// Dashboard Errors

// Priority

// Properties

// User access

// Login & Permissions

// General advertising

// Finance

// Time and date related


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}


// Advertiser

// Advertisers properties

// Campaign

// Campaign-zone linking page


// Campaign properties

// Tracker

// Banners (General)

// Banner Preferences

// Banner (Properties)

// Banner (advanced)

// Display Delviery Rules


if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}

// Website

// Website (properties)

// Website (properties - payment information)

// Website (properties - other information)

// Zone


// Advanced zone settings

// Zone probability

// Linked banners/campaigns/trackers

// Statistics

// Expiration

// Reports

// Admin_UI_Fields

// Userlog

// Code generation

// Errors

//Validation

// Email

// Priority

// Preferences

// Long names

// Short names

// Global Settings

// Product Updates

// Agency

// Channels

// Tracker Variables

// Password recovery

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit

// Widget - Audit

// Widget - Campaign



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
