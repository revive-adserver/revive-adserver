<?php

use RV\Extension\Mailer\AbstractMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class Plugins_Mailer_rvMailerMailgun_Mailer extends AbstractMailer
{
    public function getName(): string
    {
        return 'Mailgun';
    }

    public function checkConfig(): bool
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        return !empty($aConf['key']) && !empty($aConf['domain']) && parent::checkConfig();
    }

    protected function getTransport(): TransportInterface
    {
        $aConf = $GLOBALS['_MAX']['CONF'][$this->group];

        $dsn = "mailgun+api://{$aConf['key']}:{$aConf['domain']}@default";

        if (!empty($aConf['region'])) {
            $dsn .= "?region={$aConf['region']}";
        }

        return Transport::fromDSN($dsn);
    }
}
