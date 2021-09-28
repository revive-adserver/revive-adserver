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

/**
 * @package OX_Admin_UI
 * @subpackage Install
 */
class OX_Admin_UI_Install_SystemCheckModelBuilder
{
    /**
     * Process the Upgrader->getMessages(() result table
     *
     * @param array $aMessages
     *
     * @return SystemCheckModel object
     */
    public function processUpgraderMessages($aMessages, $existingInstallationStatus)
    {
        $aResult = [];

        $aCheckInfo['error'] = [];
        $aCheckInfo['warning'] = [];
        $aCheckInfo['info'] = [];

        $sErr = '#! ';
        $sWarn = '#> ';
        foreach ($aMessages as $key => $message) {
            $key = 'application';
            if (substr($message, 0, 3) == $sErr) {
                $message = str_replace($sErr, '', $message);
                $aCheckInfo['error'][$key][] = $message;
            } elseif (substr($message, 0, 3) == $sWarn) {
                $message = str_replace($sWarn, '', $message);
                $aCheckInfo['warning'][$key][] = $message;
            } else {
                $aCheckInfo['info'][] = $message; //collect messages as general
            }
        }
        $aCheckInfo['actual']['application'] = empty($aCheckInfo['error']);

        $aSection = $this->buildCheckSection($aCheckInfo, 'Previous version');
        $aSection['checks']['application'] = $this->buildCheckEntry('application', $aCheckInfo, true, 'OK', 'NOT OK');
        $aSection = $this->buildCheckSectionMessages($aCheckInfo, $aSection);

        if ($aSection['hasError']) {
            $message = $GLOBALS['strAppCheckErrors'];
            if ($existingInstallationStatus == OA_STATUS_MAX_DBINTEG_FAILED) {
                $message .= '<br>' . $GLOBALS['strAppCheckDbIntegrityError'];
            }

            $aSection['errors']['general'] = $message;
        }

        $aResult['appcheck'] = $aSection;
        $oCheckModel = new SystemCheckModel(
            $aResult,
            $aSection['hasError'],
            $aSection['hasWarning']
        );

        return $oCheckModel;
    }


    /**
     * Process the EnviromentManager checkSystem result table
     *
     * @param array $aSysInfo
     *
     * @return SystemCheckModel object
     */
    public function processEnvironmentCheck($aSysInfo)
    {
        $aResult = [];

        //cookie section
        $aEnvCookie = $aSysInfo['COOKIES'];
        $aSection = $this->buildCheckSection($aEnvCookie, $GLOBALS['strBrowserCookies']);
        $aSection['checks']['enabled'] = $this->buildCheckEntry('enabled', $aEnvCookie, true, 'OK', 'DISABLED');
        $aSection = $this->buildCheckSectionMessages($aEnvCookie, $aSection);
        $aResult['cookies'] = $aSection;

        // PHP section
        $aEnvPhp = $aSysInfo['PHP'];
        $aSection = $this->buildCheckSection($aEnvPhp, $GLOBALS['strPHPConfiguration']);

        // PHP version
        $aSection['checks']['version'] = [
            'name' => 'version',
            'value' => $aEnvPhp['actual']['version'],
            'hasWarning' => !empty($aEnvPhp['warning']['version']),
            'hasError' => !empty($aEnvPhp['error']['version']),
        ];

        // For some reason installer discards timzone check and does its own..
        $timezone = OX_Admin_Timezones::getTimezone();
        $timezoneErr = 'System/Localtime' == $timezone;
        $aSection['hasWarning'] = $timezoneErr;
        $aSection['checks']['timezone'] = [
            'name' => 'timezone',
            'value' => $timezone,
            'hasWarning' => $timezoneErr,
            'warnings' => $timezoneErr ? [$GLOBALS['strTimezoneLocal']] : null
        ];

        // Memory limit
        $memLimit = $aEnvPhp['actual']['memory_limit'];
        $memLimit = ($memLimit != '' ? $memLimit : 'Not Set');
        if (is_numeric($memLimit)) {
            // convert into MB
            $memLimit = ($memLimit / 1048576) . ' MB';
        }
        $aSection['checks']['memory_limit'] = [
            'name' => 'memory_limit',
            'value' => $memLimit,
            'warning' => $aEnvPhp['warning']['memory_limit'] ?? false,
            'error' => $aEnvPhp['error']['memory_limit'] ?? false,
        ];

        // Safe mode, magic quotes, register_argc_argv
        $aSection['checks']['safe_mode'] = $this->buildCheckEntry('safe_mode', $aEnvPhp, 0, 'OFF', 'ON');
        $aSection['checks']['register_argc_argv'] = $this->buildCheckEntry('register_argc_argv', $aEnvPhp, 0, 'OFF', 'ON');
        if ($aEnvPhp['actual']['register_argc_argv'] == 0) {
            $aSection['checks']['register_argc_argv']['warning'] = $GLOBALS['strWarningRegisterArgcArv'];
        }

        // PHP configuration's file_uploads value
        $aSection['checks']['file_uploads'] = $this->buildCheckEntry('file_uploads', $aEnvPhp, 0, 'OFF', 'ON');

        // Required PHP extensions
        $aSection['checks']['json'] = $this->buildExtensionCheckEntry('json', $aEnvPhp);
        $aSection['checks']['pcre'] = $this->buildExtensionCheckEntry('pcre', $aEnvPhp);
        $aSection['checks']['spl'] = $this->buildExtensionCheckEntry('spl', $aEnvPhp);
        $aSection['checks']['xml'] = $this->buildExtensionCheckEntry('xml', $aEnvPhp);
        $aSection['checks']['zip'] = $this->buildExtensionCheckEntry('zip', $aEnvPhp);
        $aSection['checks']['zlib'] = $this->buildExtensionCheckEntry('zlib', $aEnvPhp);

        // Disabled mbstring function overloading
        $aSection['checks']['mbstring.func_overload'] = $this->buildCheckEntry('mbstring.func_overload', $aEnvPhp, true, 'NOT OK', 'OK');

        // At least one of the required database extensions are loaded
        $aSection['checks']['mysqli'] = $this->buildExtensionCheckEntry('mysqli', $aEnvPhp);
        $aSection['checks']['pgsql'] = $this->buildExtensionCheckEntry('pgsql', $aEnvPhp);

        // Ability to set timeouts
        $aSection['checks']['timeout'] = $this->buildCheckEntry('timeout', $aEnvPhp, false, 'OFF', $aEnvPhp['actual']['timeout']);

        $aSection = $this->buildCheckSectionMessages($aEnvPhp, $aSection);
        $aResult['php'] = $aSection;

        //PERMS section
        $aEnvPerms = $aSysInfo['PERMS'];
        $aSection = $this->buildCheckSection($aEnvPerms, 'File Permissions');
        foreach ($aEnvPerms['actual'] as $idx => $aVal) {
            $aSection['checks'][$aVal['file']] = [
                'name' => $aVal['file'],
                'value' => $aVal['result'],
                'errors' => empty($aVal['message']) ? null : [$aVal['message']],
                'hasError' => $aVal['error']
            ];
        }
        $aSection = $this->buildCheckSectionMessages($aEnvPerms, $aSection);
        $aResult['perms'] = $aSection;

        $hasError = $hasWarning = false;

        foreach ($aResult as $aSection) {
            $hasError = $hasError || !empty($aSection['hasError']);
            $hasWarning = $hasWarning || !empty($aSection['hasWarning']);
        }

        $oCheckModel = new SystemCheckModel($aResult, $hasError, $hasWarning);

        return $oCheckModel;
    }


    /**
     * Builds title for the section. Also, adds meta info if section contains errors
     * or warnings.
     *
     * @param array $aSysInfoPart part of OA_UPRGADE->checkSystem result
     * @param string $title human readable check section name eg. Cookies
     * @return array an array with check section model to be passed to view
     */
    protected function buildCheckSection($aSysInfoPart, $title)
    {
        $aSection = [];
        $aSection['header'] = $title;
        if (empty($aSysInfoPart['error'])) {
            $aSection['hasError'] = false;
        } else {
            $aSection['hasError'] = true;
        }
        $aSection['hasWarning'] = !empty($aSysInfoPart['warning']);

        return $aSection;
    }



    /**
     * Updates section header appending error, warning, OK count.
     *
     * @param array $aSysInfoPart
     * @param array $aSection
     * @return array updated $aSection
     */
    protected function updateSectionHeader($aSysInfoPart, $aSection)
    {
        $errCount = 0;
        $warnCount = 0;
        foreach ($aSection['checks'] as $check) {
            if (!empty($check['hasError']) || !empty($check['errors'])) {
                $errCount++;
            }
            if (!empty($check['hasWarning']) || !empty($check['warnings'])) {
                $warnCount++;
            }
        }

        $aSection['errCount'] = $errCount;
        $aSection['warnCount'] = $warnCount;
        $okCount = count($aSection['checks']) - $errCount - $warnCount;

        $aStatus = [];
        if ($errCount) {
            $aStatus[] = " $errCount " . ($errCount > 1 ? $GLOBALS['strCheckErrors'] : $GLOBALS['strCheckError']);
        }
        if ($warnCount) {
            $aStatus[] = " $warnCount " . ($warnCount > 1 ? $GLOBALS['strCheckWarnings'] : $GLOBALS['strCheckWarning']);
        }
        if ($okCount) {
            $aStatus[] = " $okCount OK";
        }

        $aSection['header'] .= " - " . join(', ', $aStatus);

//        echo "<pre>";
//        var_dump($aSection);
//        echo "</pre>";

        return $aSection;
    }



    /**
     * Collects any section level warnings and errors (ie. ones which have not been
     * associated with a particular check) and updates given $aSection check model
     * with appropriate settings.
     *
     * Also updates section header appending error, warning, OK count.
     *
     * @param array $aSysInfoPart
     * @param array $aSection
     * @return array updated $aSection
     */
    protected function buildCheckSectionMessages($aSysInfoPart, $aSection)
    {
        if (!empty($aSysInfoPart['error'])) {
            foreach ($aSysInfoPart['error'] as $key => $errorMessage) {
                $aSection['errors'][$key] = $errorMessage;
            }
        }

        if (!empty($aSysInfoPart['warning'])) {
            foreach ($aSysInfoPart['warning'] as $key => $errorMessage) {
                $aSection['warnings'][$key] = $errorMessage;
            }
        }

        if (!empty($aSysInfoPart['info'])) {
            foreach ($aSysInfoPart['info'] as $key => $infoMessage) {
                $aSection['infos'][$key] = $infoMessage;
            }
        }

        $aSection = $this->updateSectionHeader($aSysInfoPart, $aSection);

        return $aSection;
    }


    /**
     * Builds a structure for a single check that can be used by view to display
     * check results. Uses $compareVal to check the actual value and
     * $valEqualLabel if actual check value is equal, $valOtherLabel otherwise.
     *
     * @param string $checkName check identifier, used as a key to access value, error, warnings in $aSysInfoPart
     * @param array $aSysInfoPart part of OA_UPRGADE->checkSystem result
     * @param mixed $compareVal
     * @param string $valEqualLabel
     * @param string $valOtherLabel
     * @return array
     */
    protected function buildCheckEntry($checkName, &$aSysInfoPart, $compareVal, $valEqualLabel, $valOtherLabel)
    {
        $aErrors = $this->getCheckMessages($checkName, 'error', $aSysInfoPart, true);
        $aWarnings = $this->getCheckMessages($checkName, 'warning', $aSysInfoPart, true);
        $aInfos = $this->getCheckMessages($checkName, 'info', $aSysInfoPart, true);

        $aCheck = [
            'name' => $checkName,
            'value' => $aSysInfoPart['actual'][$checkName] == $compareVal ? $valEqualLabel : $valOtherLabel,
            'hasWarning' => !empty($aWarnings),
            'warnings' => $aWarnings,
            'hasError' => !empty($aErrors),
            'errors' => $aErrors,
            'hasInfo' => !empty($aInfos),
            'infos' => $aInfos
        ];

        return $aCheck;
    }


    /**
     * Gets messages or given type for given check from the given sys array.
     * If clear is set, also unsets the messages from the sys array.
     *
     * Returns value of $aSysInfoPart[$messageType][$checkName];
     *
     * @param string $checkName
     * @param string $messageType
     * @param array $aSysInfoPart part of OA_UPRGADE->checkSystem result
     * @param boolean $clear whether to unset $aSysInfoPart[$messageType][$checkName]
     */
    private function getCheckMessages($checkName, $messageType, &$aSysInfoPart, $clear = true)
    {
        $hasMessages = isset($aSysInfoPart[$messageType][$checkName])
            && !empty($aSysInfoPart[$messageType][$checkName]);

        $aMessages = $hasMessages
            ? is_array($aSysInfoPart[$messageType][$checkName])
                ? $aSysInfoPart[$messageType][$checkName]
                : [$aSysInfoPart[$messageType][$checkName]]
            : null;

        if ($clear && $hasMessages) {
            unset($aSysInfoPart[$messageType][$checkName]); //clear the check associated message
        }

        return $aMessages;
    }


    /**
     * A shorthand function for extension checks, calls buildCheckEntry
     * internally
     *
     * @param string $checkName check identifier, used as a key to access value, error, warnings in $aSysInfoPart
     * @param array $aSysInfoPart part of OA_UPRGADE->checkSystem result
     * @return array
     */
    protected function buildExtensionCheckEntry($checkName, $aSysInfoPart)
    {
        return $this->buildCheckEntry($checkName, $aSysInfoPart, true, 'LOADED', 'NOT LOADED');
    }
}

class SystemCheckModel
{
    private $aSections;
    private $hasError;
    private $hasWarning;


    public function __construct($aSections, $hasError, $hasWarning)
    {
        $this->aSections = $aSections;
        $this->hasError = $hasError;
        $this->hasWarning = $hasWarning;
    }


    public function getSections()
    {
        return $this->aSections;
    }


    public function hasError()
    {
        return $this->hasError;
    }


    public function hasWarning()
    {
        return $this->hasWarning;
    }


    public function hasSectionError($sectionName)
    {
        return isset($this->aSections[$sectionName])
            && $this->aSections[$sectionName]['hasError'];
    }


    public function hasSectionWarning($sectionName)
    {
        return isset($this->aSections[$sectionName])
            && $this->aSections[$sectionName]['hasWarning'];
    }
}
