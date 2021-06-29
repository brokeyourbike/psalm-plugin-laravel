<?php

namespace BrokeYourBike\LaravelPlugin\Providers;

interface GeneratesStubs
{
    public static function generateStubFile(): void;
    public static function getStubFileLocation(): string;
}
