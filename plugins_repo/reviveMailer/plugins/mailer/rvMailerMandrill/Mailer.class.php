<?php

use RV\Extension\Mailer\AbstractMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class Plugins_Mailer_rvMailerMandrill_Mailer extends AbstractMailer
{
    public function getName(): string
    {
        return 'Mandrill';
    }

    public function checkConfig(): bool
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        return !empty($aConf['key']) && parent::checkConfig();
    }

    protected function getTransport(): TransportInterface
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        $dsn = 'mandrill+api://' . $aConf['key'];

        return Transport::fromDSN($dsn);
    }
}
