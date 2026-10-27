<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

namespace RV\Sync\Dto;

final class Software
{
    public ?string $osType = null;
    public ?string $osVersion = null;
    public ?string $webserverType = null;
    public ?string $webserverVersion = null;
    public ?string $dbType = null;
    public ?string $dbVersion = null;
    public ?string $phpVersion = null;
    public ?string $phpSapi = null;

    /** @var string[]|null */
    public ?array $phpExtensions = null;

    public ?bool $phpRegisterGlobals = null;
    public ?bool $phpMagicQuotesGpc = null;
    public ?bool $phpSafeMode = null;
    public ?bool $phpOpenBasedir = null;
    public ?bool $phpUploadTmpReadable = null;
}
