<?php

namespace RV\Admin\Install;

class RedirectException extends \Exception
{
    /** @var string */
    private $action;

    public function __construct(string $action)
    {
        $this->action = $action;

        parent::__construct();
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
