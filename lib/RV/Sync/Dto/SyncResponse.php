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

use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;

final class SyncResponse
{
    /** @var array<array<string, mixed>>|null */
    public ?array $updates = null;

    public static function fromJson(string $json, SerializerInterface $serializer): self
    {
        $decoded = json_decode($json, false, 512, JSON_THROW_ON_ERROR);
        if (!$decoded instanceof \stdClass || !property_exists($decoded, 'updates')
            || !is_array($decoded->updates) || !array_is_list($decoded->updates)) {
            throw new RuntimeException('Invalid response from the sync server.');
        }

        return $serializer->deserialize($json, self::class, 'json');
    }

    public function toLegacyUpdates(SerializerInterface $serializer): array
    {
        if ($this->updates === null || !array_is_list($this->updates)) {
            throw new RuntimeException('Invalid response from the sync server.');
        }

        $updates = [];
        foreach ($this->updates as $release) {
            if (!is_array($release)
                || !isset($release['config_version']) || !is_numeric($release['config_version'])
                || !isset($release['security_fix']) || !in_array($release['security_fix'], [0, 1], true)) {
                throw new RuntimeException('Invalid release information from the sync server.');
            }
            foreach (['product_name', 'config_readable', 'description'] as $field) {
                if (!isset($release[$field]) || !is_string($release[$field])) {
                    throw new RuntimeException('Invalid release information from the sync server.');
                }
            }
            foreach (['url_zip', 'url_tgz'] as $field) {
                if (isset($release[$field]) && !is_string($release[$field])) {
                    throw new RuntimeException('Invalid release information from the sync server.');
                }
            }
            $update = $serializer->denormalize($release, Update::class);
            $updates[] = $update->toLegacyArray();
        }

        return $updates;
    }
}
