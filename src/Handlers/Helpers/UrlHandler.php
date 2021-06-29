<?php declare(strict_types=1);

namespace BrokeYourBike\LaravelPlugin\Handlers\Helpers;

use Psalm\Type\Union;
use Psalm\Type\Atomic\TNamedObject;
use Psalm\Type;
use Psalm\StatementsSource;
use Psalm\Plugin\Hook\FunctionReturnTypeProviderInterface;
use Psalm\Context;
use Psalm\CodeLocation;
use Illuminate\Contracts\Routing\UrlGenerator;

final class UrlHandler implements FunctionReturnTypeProviderInterface
{
    public static function getFunctionIds(): array
    {
        return ['url'];
    }

    public static function getFunctionReturnType(
        StatementsSource $statements_source,
        string $function_id,
        array $call_args,
        Context $context,
        CodeLocation $code_location
    ) : ?Union {
        if (!$call_args) {
            return new Union([
                new TNamedObject(UrlGenerator::class),
            ]);
        }

        return Type::getString();
    }
}
