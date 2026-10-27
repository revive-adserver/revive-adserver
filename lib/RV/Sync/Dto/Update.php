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

final class Update
{
    #[SerializedName('product_name')]
    public string $productName = '';

    #[SerializedName('config_version')]
    public string|int|float $configVersion = '';

    #[SerializedName('config_readable')]
    public string $configReadable = '';

    #[SerializedName('security_fix')]
    public int $securityFix = 0;

    public string $description = '';

    #[SerializedName('url_zip')]
    public ?string $urlZip = null;

    #[SerializedName('url_tgz')]
    public ?string $urlTgz = null;

    public function toLegacyArray(): array
    {
        return [
            'product_name' => $this->productName,
            'config_version' => (string) $this->configVersion,
            'config_readable' => $this->configReadable,
            'security_fix' => $this->securityFix,
            'description' => $this->description,
            'url_zip' => $this->urlZip ?? '',
            'url_tgz' => $this->urlTgz ?? '',
        ];
    }
}
