<?php

/**
 * A stub implementation of the cached container
 */
class ReviveAdserverCachedContainer implements \Psr\Container\ContainerInterface
{
    public function get(string $id)
    {
        return null;
    }

    public function has(string $id): bool
    {
        return false;
    }
}
