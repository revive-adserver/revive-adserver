<?php

declare(strict_types=1);

namespace RV\Manager;

class PasswordManager
{
    private const ALGO = PASSWORD_BCRYPT;
    private const OPTIONS = [
        'cost' => PASSWORD_BCRYPT_DEFAULT_COST,
    ];

    public static function getPasswordHash(string $password): string
    {
        return \password_hash($password, self::ALGO, self::OPTIONS);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return \password_verify($password, $hash);
    }

    public static function needsRehash(\DataObjects_Users $doUsers): bool
    {
        return \password_needs_rehash($doUsers->password, self::ALGO, self::OPTIONS);
    }

    public static function updateHash(\DataObjects_Users $doUsers, string $password): void
    {
        $doUsers->password = self::getPasswordHash($password);
        $doUsers->update();
    }
}
