<?php

use RV\Extension\Mailer\AbstractMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class Plugins_Mailer_rvMailerSendgrid_Mailer extends AbstractMailer
{
    public function getName(): string
    {
        return 'Sendgrid';
    }

    public function checkConfig(): bool
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        return !empty($aConf['key']) && parent::checkConfig();
    }

    protected function getTransport(): TransportInterface
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        $dsn = 'sendgrid' . (empty($aConf['api']) ? 'smtp' : 'api') . '://' . $aConf['key'];

        return Transport::fromDSN($dsn);
    }
}
