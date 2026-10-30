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
        return Transport::fromDSN($this->getDsn());
    }

    protected function getDsn(): string
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        $dsn = 'smtp' . (empty($aConf['tls']) ? '' : 's') . '://';

        if (!empty($aConf['user']) && !empty($aConf['password'])) {
            $dsn .= rawurlencode($aConf['user']) . ':' . rawurlencode($aConf['password']) . '@';
        }

        $dsn .= $aConf['hostname'] . ':' . $aConf['port'];

        return $dsn;
    }
}
