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

namespace RV\Config;

use Symfony\Component\Config\Resource\SelfCheckingResourceChecker;
use Symfony\Component\Config\ResourceCheckerConfigCache;
use Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfigCache extends ResourceCheckerConfigCache
{
    /**
     * @param string $file                  The absolute cache path
     * @param ContainerInterface $container The container with parameters
     */
    public function __construct($file, ContainerInterface $container)
    {
        $checkers = [
            new ContainerParametersResourceChecker($container),
            new SelfCheckingResourceChecker(),
        ];

        parent::__construct($file, $checkers);
    }
}