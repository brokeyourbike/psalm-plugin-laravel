<?php

namespace BrokeYourBike\LaravelPlugin\Providers;

final class CacheDirectoryProvider
{
    public static function getCacheLocation(): string
    {
        return __DIR__ . '/../../cache';
    }
}
