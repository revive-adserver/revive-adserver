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
$Id:invocation.lang.php 20042 2008-05-09 01:10:00Z aj.tarachanowicz@openx.org $
*/

/** status messages **/
$GLOBALS['strInstallStatusRecovery']           = 'Recovering OpenX %s';
$GLOBALS['strInstallStatusInstall']            = 'Installing OpenX %s';
$GLOBALS['strInstallStatusUpgrade']            = 'Upgrading to OpenX %s';
$GLOBALS['strInstallStatusUpToDate']           = 'Detected OpenX %s';        


/** welcome step **/
$GLOBALS['strWelcomeTitle']                     = "Welcome to ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallIntro']                     = "Thank you for choosing ".MAX_PRODUCT_NAME.". This wizard will guide you through the process of installing the ".MAX_PRODUCT_NAME." ad server.";
$GLOBALS['strUpgradeIntro']                     = "Thank you for choosing ".MAX_PRODUCT_NAME.". This wizard will guide you through the process of upgrading the ".MAX_PRODUCT_NAME." ad server.";
$GLOBALS['strInstallerHelpIntro']               = "To help you with the installation process we have created an <a href='".OX_PRODUCT_DOCSURL."/wizard/qsg-install' target='_blank'>Installation Quick Start Guide</a> to take you through the process of getting up and running.
                                                   For a more detailed guide to installing and configuring ".MAX_PRODUCT_NAME." visit the <a href='".OX_PRODUCT_DOCSURL."/wizard/admin-guide' target='_blank'>Administrator Guide</a>.";
$GLOBALS['strTermsIntro']                       = MAX_PRODUCT_NAME . " is distributed freely under an Open Source license, the GNU General Public License. Please review and agree to the following documents to continue the installation.";

/** check step **/
$GLOBALS['strSystemCheck']                     = "System check";
$GLOBALS['strSystemCheckIntro']                = "The install wizard perfomed a check of your web server settings to ensure that the installation process can complete successfully.
                                                 <br>Please check any highlighted issues to complete the installation process.";
$GLOBALS['strFixErrorsBeforeContinuing']       = "Configuration of your webserver does not meet the requirements of the ".MAX_PRODUCT_NAME.". 
                                                  <br>In order to proceed with installation, please fix all errors.
                                                  For help, please see our <a href='".OX_PRODUCT_DOCSURL."'>documentation</a>, <a href='http://"
                                                  .OX_PRODUCT_DOCSURL."/faq'>FAQs</a> and <a href='http://".OX_PRODUCT_FORUMURL."'>forum</a>";
                                                  
$GLOBALS['strAppCheckErrors']                  = "Errors were found when detecing previous installations of ".MAX_PRODUCT_NAME;
$GLOBALS['strAppCheckDbIntegrityError']        = "We have detected integrity issues with your database. This means that the layout of your database 
                                                  differs from what we expect it to be. This could be due to customization of your database.";

$GLOBALS['strSyscheckProgressMessage']         = "Checking system parameters...";


/** admin login step **/
$GLOBALS['strAdminLoginTitle']                 = "Please login as your ".MAX_PRODUCT_NAME." administrator";
$GLOBALS['strAdminLoginIntro']                 = "To continue, please enter your ".MAX_PRODUCT_NAME." administrator account login information.";
$GLOBALS['strLoginProgressMessage']            = 'Logging in...';

/** sso register step **/
$GLOBALS['strRegisterTitle']                    = "Register with OpenX";
$GLOBALS['strRegisterIntro']                    = "Please register with OpenX to continue. By registering, you'll get an OpenX.org account which will enable you to:";
$GLOBALS['strMarketBenefitMonetizeTitle']       = "Monetize your sites through OpenX Market";
$GLOBALS['strMarketBenefitMonetizeDesc']        = "OpenX Market is a free service that helps place higher paying ads on your websites";
$GLOBALS['strMarketBenefitSupportTitle']        = "Find answers to your questions on OpenX Forums";
$GLOBALS['strMarketBenefitSupportDesc']         = "OpenX Forums lets you communicate with OpenX staff and users to get support for your questions";
$GLOBALS['strMarketBenefitPluginsTitle']        = "Extend your ad server with plugins from OpenX";
$GLOBALS['strMarketBenefitPluginsDesc']         = "More plugins providing services from OpenX and 3rd parties are coming soon to provide even more powerful features";
$GLOBALS['strMarketBenefitSecurityTitle']       = "Get notified of the latest security updates";
$GLOBALS['strMarketBenefitSecurityDesc']        = "You'll be immediately notified of the latest product versions and security updates";
$GLOBALS['strMarketIntroTitle']                 = "OpenX Market — A new addition to OpenX to help you make more money";
$GLOBALS['strMarketIntro']                      = "OpenX Market places higher paying ads on your site by allowing you to sell 
                                                    your ad space to advertisers bidding in a competitive auction.";
$GLOBALS['strStatusAvailable']                  = "Available";
$GLOBALS['strStatusNotAvailable']               = "Not available";
$GLOBALS['strStatusChecking']                   = "Checking...";

$GLOBALS['strProvideOpenXAccount']              = "Provide an OpenX.org account";
$GLOBALS['strCreateOpenXAccount']               = "Create an OpenX.org account";
$GLOBALS['strWhatIsOpenXAccount']               = "An OpenX.org account is an account which you may use to login to a variety of OpenX products like OpenX Hosted, the OpenX Community Forums, and more."; 
$GLOBALS['strGetStartedWithAccount']            = "To get started, provide your OpenX.org account. If you don't have an OpenX.org account, you may create a new one below.";
$GLOBALS['strHaveOpenXAccountQuestion']         = "Do you already have an OpenX.org account?";
$GLOBALS['strHaveOpenXAccount']                 = "I <em>have</em> an OpenX.org account";
$GLOBALS['strDoNotHaveOpenXAccount']            = "I <em>do not have</em> an OpenX.org account";
$GLOBALS['strOpenXUsername']                    = "OpenX.org Username";

$GLOBALS['strCaptcha']                          = 'Type the text shown in the image';
$GLOBALS['strCaptchaReload']                    = 'Try a different image';
$GLOBALS['strCaptchaLettersCaseInsensitive']    = 'Letters are not case sensitive';
$GLOBALS['strBtnCreateAccountAndContinue']      = 'Create my account and continue »';

$GLOBALS['strPasswordMismatch']                 = 'The given passwords do not match';
$GLOBALS['strCaptchaRequired']                  = 'Please type the code shown';
$GLOBALS['strSSOUsernameNotAvailable']          = 'This OpenX.org username is not available';

$GLOBALS['strRegisterConfirmTitle']             = "Registration successful";
$GLOBALS['strRegisterConfirmIntro']             = "Your OpenX.org account has successfully been created.";
$GLOBALS['strRegisterProgressMessage']         = 'Registering OpenX.org account...';

/** database step **/
$GLOBALS['strDbSetupTitle']                     = "Provide your database";
$GLOBALS['strDbSetupIntro']                     = "Provide the details to connect to your ".MAX_PRODUCT_NAME." database.";
$GLOBALS['strDbUpgradeTitle']                   = "Your database has been detected";
$GLOBALS['strDbUpgradeIntro']                   = "The following database has been detected for your installation of " . MAX_PRODUCT_NAME . ". 
                                                   Please verify that this is correct then click \"Continue\" to proceed.";
$GLOBALS['strDbProgressMessageInstall']         = 'Installing database...';
$GLOBALS['strDbProgressMessageUpgrade']         = 'Upgrading database...';
$GLOBALS['strDbSeeMoreFields']                  = 'See more database fields...';
$GLOBALS['strDbTimeZoneWarning']                = "<p>As of this version " . MAX_PRODUCT_NAME . " stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings']             = "Do not display timezone warnings in the future";
$GLOBALS['strDBInstallSuccess']                 = 'Database created successfully';
$GLOBALS['strDBUpgradeSuccess']                = 'Database upgraded successfully';


$GLOBALS['strDetectedVersion']                  = 'Detected Ad Server version';


/** config step **/
$GLOBALS['strConfigureInstallTitle']            = 'Configure your local ' . MAX_PRODUCT_NAME . ' administrator account';
$GLOBALS['strConfigureInstallIntro']            = 'Please provide the desired login information for your local ' . MAX_PRODUCT_NAME . ' administrator account.';
$GLOBALS['strConfigureUpgradeTitle']            = 'Configuration settings';
$GLOBALS['strConfigureUpgradeIntro']            = 'Provide the path to your previous ' . MAX_PRODUCT_NAME . ' installation.';
$GLOBALS['strConfigSeeMoreFields']              = 'See more configuration fields...';
$GLOBALS['strPreviousInstallTitle']             = "Previous installation";
$GLOBALS['strPathToPrevious']                   = "Path to previous " . MAX_PRODUCT_NAME . " installation";
$GLOBALS['strPathToPreviousHint']               = "Plugin files must be copied from the path based on your previous install";
$GLOBALS['strPathToPreviousError']              = "One or more plugin files couln't be located, check the install.log file for more information";

$GLOBALS['strConfigureProgressMessage']         = 'Configuring ' . MAX_PRODUCT_NAME . '...';                                                  


/** jobs step **/
$GLOBALS['strJobsInstallTitle']                 = 'Performing installation tasks';
$GLOBALS['strJobsInstallIntro']                 = 'Installer is now performing final installation tasks.';
$GLOBALS['strJobsUpgradeTitle']                 = 'Performing upgrade tasks'; 
$GLOBALS['strJobsUpgradeIntro']                 = 'Installer is now performing final upgrade tasks.';
$GLOBALS['strJobsProgressInstallMessage']       = 'Running installation tasks...';
$GLOBALS['strJobsProgressUpgradeMessage']       = 'Running upgrade tasks...';

$GLOBALS['strPluginTaskChecking']               = 'Checking ' . MAX_PRODUCT_NAME . ' Plugin';
$GLOBALS['strPluginTaskInstalling']             = 'Installing ' . MAX_PRODUCT_NAME . ' Plugin';
$GLOBALS['strPostInstallTaskRunning']           = 'Running task';

/** finish step **/
$GLOBALS['strFinishInstallTitle']               = 'Your ' . MAX_PRODUCT_NAME . ' installation is complete.';
$GLOBALS['strFinishUpgradeWithErrorsTitle']     = 'Your ' . MAX_PRODUCT_NAME . ' upgrade is complete. Please check the highlighted issues.';
$GLOBALS['strFinishUpgradeTitle']               = 'Your ' . MAX_PRODUCT_NAME . ' upgrade is complete.';
$GLOBALS['strFinishInstallWithErrorsTitle']     = 'Your ' . MAX_PRODUCT_NAME . ' installation is complete. Please check the highlighted issues.';
$GLOBALS['strInstallNonBlockingErrors']         = "An error occurred when performing installation tasks. Please check the <a class=\"show-errors\" href=\"#\">error list</a> 
                                                   and install log at '%s' for details. You will still be able to login to your OpenX instance.";
$GLOBALS['strDetailedTaskErrorList']            = 'Detailed list of errors found';
$GLOBALS['strPluginInstallFailed']              = "Installation of plugin '%s' failed:";
$GLOBALS['strTaskInstallFailed']                = "Error occured when running installation task '%s':";
$GLOBALS['strContinueToLogin']                  = 'Click "Continue" to login to your OpenX instance.';

$GLOBALS['strMarketIntroTitle']                 =

$GLOBALS['strContinue']                         = "Continue";
$GLOBALS['strDBCreatedSuccessful']              = "Your database has successfully been created for ". MAX_PRODUCT_NAME;
$GLOBALS['strPluginsDefault']                   = MAX_PRODUCT_NAME." Plugins";
$GLOBALS['strPostUpgradeTasks']                 = MAX_PRODUCT_NAME." Post-Upgrade Tasks";
$GLOBALS['strInstallComplete']                  = "Your ".MAX_PRODUCT_NAME." installation is now complete.";
$GLOBALS['strSignupUpdates']                    = "Sign up for product updates and security alerts";
$GLOBALS['strUpgradeComplete']                  = "Congratulations, you have finished upgrading ". MAX_PRODUCT_NAME;
$GLOBALS['strUnableCreateConfFile']             = "We are unable to create your configuration file. Please re-check the permissions of the ". MAX_PRODUCT_NAME ." var folder.";
$GLOBALS['strUnableUpdateConfFile']             = "We are unable to update your configuration file. Please re-check the permissions of the ". MAX_PRODUCT_NAME ." var folder, and also check the permissions of the previous install's config file that you copied into this folder.";
$GLOBALS['strUnableToCreateAdmin']              = "We are unable to create an administrator account, is your database accessible?";
$GLOBALS['strTimezoneLocal']                    = MAX_PRODUCT_NAME . " has detected that your PHP installation is returning 'System/Localtime' as the ".
                                                  "timezone of your server. This is because of a patch to PHP applied by some Linux distributions. " .
                                                  "Unfortunately, this is not a valid PHP timezone. Please edit your php.ini file and set the 'date.timezone' " .
                                                  "property to the correct value for your server."; 
$GLOBALS['strMarketIntroLongTitle']             = "To optimize your revenue, OpenX Market will start serving ads in new zones which you create";
$GLOBALS['strMarketIntroLong']                  = "OpenX Market is a free service that places ads on your site. It uses a real-time auction and an optimized portfolio
                                                   of ad networks to deliver the highest paying ads to your zones. It will automatically serve ads to each new zone
                                                   that you create as long as the zone doesn't have other ads to serve. This optimizes your revenue by helping you
                                                   avoid blank ads. You can change this behavior by editing the zone.";

                                                  


?>
