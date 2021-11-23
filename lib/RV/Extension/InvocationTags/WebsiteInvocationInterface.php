<?php

namespace RV\Extension\InvocationTags;

interface WebsiteInvocationInterface
{
    public function generateWebsiteInvocationCode(): string;

    public function isWebsiteDefault(): bool;
}
