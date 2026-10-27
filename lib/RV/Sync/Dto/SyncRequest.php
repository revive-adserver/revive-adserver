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

use Symfony\Component\Serializer\Attribute\SerializedName;

final class SyncRequest
{
    public string $product;
    public string $version;

    #[SerializedName('platform_hash')]
    public string $platformHash;

    public string $email;
    public Software $software;

    public function __construct(string $product, string $version, string $platformHash, string $email, ?Software $software = null)
    {
        $this->product = $product;
        $this->version = $version;
        $this->platformHash = $platformHash;
        $this->email = $email;
        $this->software = $software ?? new Software();
    }
}
