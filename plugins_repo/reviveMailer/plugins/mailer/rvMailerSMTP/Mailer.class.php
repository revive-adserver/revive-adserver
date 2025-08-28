<?php

use RV\Extension\Mailer\AbstractMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class Plugins_Mailer_rvMailerSMTP_Mailer extends AbstractMailer
{
    public function getName(): string
    {
        return 'SMTP';
    }

    public function getPriority(): int
    {
        return 1000;
    }

    protected function getTransport(): TransportInterface
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        $dsn = 'smtp' . (empty($aConf['tls']) ? '' : 's') . '://';

        if (!empty($aConf['user']) && !empty($aConf['password'])) {
            $dsn .= $aConf['user'] . ':' . $aConf['password'] . '@';
        }

        $dsn .= $aConf['host'] . ':' . $aConf['port'];

        return Transport::fromDSN($dsn);
    }
}
