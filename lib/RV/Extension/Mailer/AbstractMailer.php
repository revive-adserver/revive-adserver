<?php

namespace RV\Extension\Mailer;

use RV\Extension\MailerComponentInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;

abstract class AbstractMailer extends \OX_Component implements MailerComponentInterface
{
    public function send(Email $email): void
    {
        $this->getTransport()->send($email);
    }

    public function checkConfig(): bool
    {
        try {
            $this->getTransport();
        } catch (\Exception $e) {
            \OA::debug(self::class . ' Config check failed: ' . $e->getMessage());
            return false;
        }

        return true;
    }

    public function getPriority(): int
    {
        return 0;
    }

    abstract protected function getTransport(): TransportInterface;
}
