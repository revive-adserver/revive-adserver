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

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
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
        $aResult = array();

        $aCheckInfo['error'] = array();
        $aCheckInfo['warning'] = array();
        $aCheckInfo['info'] = array();

        $sErr  = '#! ';
        $sWarn = '#> ';
        foreach ($aMessages AS $key => $message) {
            $key = 'application';
            if (substr($message, 0 , 3) == $sErr) {
                $message = str_replace($sErr, '', $message);
                $aCheckInfo['error'][$key][] = $message;
            }
            else if (substr($message, 0, 3) == $sWarn) {
                $message = str_replace($sWarn, '', $message);
                $aCheckInfo['warning'][$key][] = $message;
            }
            else {
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
                $message .= '<br>'.$GLOBALS['strAppCheckDbIntegrityError'];
            }
            
            $aSection['errors']['general'] = $message;            
        }
        
        $aResult['appcheck'] = $aSection;
        $oCheckModel = new SystemCheckModel($aResult, $aSection['hasError'], 
            $aSection['hasWarning']);
        
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
                
        $aResult = array();
        
        //cookie section 
        $aEnvCookie = $aSysInfo['COOKIES'];
        $aSection = $this->buildCheckSection($aEnvCookie, 'Cookies');        
        $aSection['checks']['enabled'] = $this->buildCheckEntry('enabled', $aEnvCookie, true, 'OK', 'DISABLED');
        $aSection = $this->buildCheckSectionMessages($aEnvCookie, $aSection);
        $aResult['cookies'] = $aSection;
        
        //PHP section
        $aEnvPhp = $aSysInfo['PHP'];
        //for some reason installer discards timzone check and does its own..
        $timezone = OX_Admin_Timezones::getTimezone();
        $timezoneErr = 'System/Localtime' == $timezone;
        $aSection = $this->buildCheckSection($aEnvPhp, 'PHP');        
        $aSection['hasWarning'] = $timezoneErr; 
        $aSection['checks']['timezone'] =  array(
            'name' => 'timezone', 
            'value' => $timezone,
            'hasWarning' => $timezoneErr,
            'warnings' => $timezoneErr ? array($GLOBALS['strTimezoneLocal']) : null
        );  
        
        $aSection['checks']['version'] = array(
            'name' => 'version',
            'value'=> $aEnvPhp['actual']['version'],
            'warning' => $aEnvPhp['warning']['version'],
            'error' => $aEnvPhp['error']['version']
        );

        $memLimit = $aEnvPhp['actual']['memory_limit'];
        $memLimit = ($memLimit !='' ? $memLimit : 'Not Set');
        if(is_numeric($memLimit)) {
            // convert into MB
            $memLimit = ($memLimit / 1048576) . ' MB';
        }
        $aSection['checks']['memory_limit'] = array(
            'name' => 'memory_limit', 
            'value' => $memLimit,
            'warning' => $aEnvPhp['warning']['memory_limit'],
            'error' => $aEnvPhp['error']['memory_limit'],
        );
        
        $aSection['checks']['safe_mode'] = $this->buildCheckEntry('safe_mode', $aEnvPhp, 0, 'OFF', 'ON');
        $aSection['checks']['magic_quotes_runtime'] = $this->buildCheckEntry('magic_quotes_runtime', $aEnvPhp, 0, 'OFF', 'ON');
        $aSection['checks']['file_uploads'] = $this->buildCheckEntry('file_uploads', $aEnvPhp, 0, 'OFF', 'ON');
        $aSection['checks']['timeout'] = $this->buildCheckEntry('timeout', $aEnvPhp, false, 'OFF', $aEnvPhp['actual']['timeout']);
        $aSection['checks']['register_argc_argv'] = $this->buildCheckEntry('register_argc_argv', $aEnvPhp, 0, 'OFF', 'ON');
        if ($aEnvPhp['actual']['register_argc_argv'] == 0) {
                $aSection['checks']['register_argc_argv']['warning'] = $GLOBALS['strWarningRegisterArgcArv'];
        }
        $aSection['checks']['pcre'] = $this->buildExtensionCheckEntry('pcre', $aEnvPhp);
        $aSection['checks']['xml'] = $this->buildExtensionCheckEntry('xml', $aEnvPhp);
        $aSection['checks']['zlib'] = $this->buildExtensionCheckEntry('zlib', $aEnvPhp);
        $aSection['checks']['spl'] = $this->buildExtensionCheckEntry('spl', $aEnvPhp);        
        $aSection['checks']['mbstring.func_overload'] = $this->buildCheckEntry('mbstring.func_overload', $aEnvPhp, true, 'NOT OK', 'OK');
        
        $aSection['checks']['mysql'] = $this->buildExtensionCheckEntry('mysql', $aEnvPhp);
        $aSection['checks']['pgsql'] = $this->buildExtensionCheckEntry('pgsql', $aEnvPhp);
        
        $aSection = $this->buildCheckSectionMessages($aEnvPhp, $aSection);
        $aResult['php'] = $aSection;
        
        //PERMS section
        $aEnvPerms = $aSysInfo['PERMS'];
        $aSection = $this->buildCheckSection($aEnvPerms, 'File Permissions');        
        foreach ($aEnvPerms['actual'] as $idx => $aVal) {
            $aSection['checks'][$aVal['file']] = array(
                'name' => $aVal['file'],
                'value'=> $aVal['result'],
                'hasError' => $aVal['error']
            );
        }
        $aSection = $this->buildCheckSectionMessages($aEnvPerms, $aSection);                
        
        $aResult['perms'] = $aSection;
        
        foreach ($aResult as $aSection) {
            $hasError = $hasError || $aSection['hasError'];
            $hasWarning = $hasWarning || $aSection['hasWarning'];
        }
        
        $oCheckModel = new SystemCheckModel($aResult, $hasError, $hasWarning);
        
        return $oCheckModel;
    }    
    
    
    /**
     * Builds title for the section, conditionally appending error string to
     * it if errors occured. Also, adds meta info if section contains errors
     * or warnings.
     *
     * @param array $aSysInfoPart part of OA_UPRGADE->checkSystem result
     * @param string $title human readable check section name eg. Cookies
     * @return array an array with check section model to be passed to view
     */
    protected function buildCheckSection($aSysInfoPart, $title)
    {
        $aSection = array();
        $aSection['header'] = $title;
        if(empty($aSysInfoPart['error'])) {
            $aSection['header'].=' - OK';
            $aSection['hasError'] = false;
        }
        else {
            $aSection['header'].=' - errors detected';
            $aSection['hasError'] = true;
        }
        $aSection['hasWarning'] = !empty($aSysInfoPart['warning']);
        
        return $aSection;
    }
    
    
    /**
     * Collects any section level warnings and errors (ie. ones which have not been
     * associated with a particular check) and updates given $aSection check model
     * with appropriate settings.
     *
     * @param array $aSysInfoPart
     * @param array $aSection
     * @return array updated $aSection
     */
    protected function buildCheckSectionMessages($aSysInfoPart, $aSection)
    {
        if(is_array($aSysInfoPart['error'])) {
            foreach ($aSysInfoPart['error'] AS $key => $errorMessage) {
                $aSection['errors'][$key] = $errorMessage;
            }
        }
        
        if(is_array($aSysInfoPart['warning'])) {
            foreach ($aSysInfoPart['warning'] AS $key => $errorMessage) {
                $aSection['warnings'][$key] = $errorMessage;
            }
        }
        
        if(is_array($aSysInfoPart['info'])) {
            foreach ($aSysInfoPart['info'] AS $key => $infoMessage) {
                $aSection['infos'][$key] = $infoMessage;
            }
        }
        
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
        
        $aCheck = array(
            'name' => $checkName,
            'value'=> $aSysInfoPart['actual'][$checkName] == $compareVal ? $valEqualLabel : $valOtherLabel,
            'hasWarning' => !empty($aWarnings),
            'warnings' => $aWarnings,
            'hasError' => !empty($aErrors),
            'errors' => $aErrors,
            'hasInfo' =>!empty($aInfos),
            'infos' => $aInfos 
        );
        
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
                :  array($aSysInfoPart[$messageType][$checkName])
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
        return isset($aSections[$sectionName]) 
            && $aSections[$sectionName]['hasError'];     
    }
    
    
    public function hasSectionWarning($sectionName)
    {
        return isset($aSections[$sectionName]) 
            && $aSections[$sectionName]['hasWarning'];
    }
    
    
}

?>