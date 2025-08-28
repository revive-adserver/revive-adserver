<?php

namespace RV\Extension;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;

interface MailerComponentInterface
{
    /**
     * @throws TransportExceptionInterface
     */
    public function send(Email $email): void;

    public function checkConfig(): bool;

    public function getPriority(): int;
}
