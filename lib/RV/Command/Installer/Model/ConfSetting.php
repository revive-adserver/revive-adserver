<?php

namespace RV\Command\Installer\Model;

class ConfSetting
{
    public const TYPE_DB = 'db';
    public const TYPE_CONF = 'conf';

    /** @var bool */
    private $required;

    /** @var string[] */
    private $destination;

    /** @var mixed */
    private $default = null;

    /**
     * @param bool $required
     * @param string|string[] $destination
     * @param mixed|null $default
     */
    public function __construct(bool $required, $destination, $default = null)
    {
        $this->required = $required;
        $this->destination = is_array($destination) ? $destination : [$destination];
        $this->default = $default;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return string[]
     */
    public function getDestination(): array
    {
        return $this->destination;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }
}
