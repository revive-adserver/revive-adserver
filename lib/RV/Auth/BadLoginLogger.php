<?php

namespace RV\Auth;

require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';

/**
 *  The intention of this class is to let fail2ban or other similar solution know that a bad login occurred.
 *  Then, after repeated attempts, fail2ban can take measures such as blocking the ip.
 *  This prevents brute forcing.
 *
 *  Log file path is not set by default, but can be set in the security settings.
 */
class BadLoginLogger
{
    private readonly string $logPath;

    public function __construct(?array $aConf = null)
    {
        if (null === $aConf) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        }

        $this->logPath = $aConf['security']['badLoginLogPath'] ?? '';
    }

    public function log(): void
    {
        if ('' === $this->logPath) {
            return;
        }

        MAX_remotehostSetRealIpAddress();

        if (empty($_SERVER['REMOTE_ADDR'])) {
            return;
        }

        @file_put_contents($this->logPath, gmdate('U') . ": " . $_SERVER['REMOTE_ADDR'] . "\n", FILE_APPEND);
    }
}
