<?php

use RV\Extension\Mailer\AbstractMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class Plugins_Mailer_rvMailerCustomDSN_Mailer extends AbstractMailer
{
    public function getName(): string
    {
        return $this->oTrans->translate('Custom Symfony Mailer DSN');
    }

    public function getPriority(): int
    {
        return -1000;
    }

    protected function getTransport(): TransportInterface
    {
        return Transport::fromDSN($GLOBALS['_MAX']['CONF'][$this->group]['dsn']);
    }
}
