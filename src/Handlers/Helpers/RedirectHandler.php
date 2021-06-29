<?php declare(strict_types=1);

namespace BrokeYourBike\LaravelPlugin\Handlers\Helpers;

use Psalm\Type;
use Psalm\StatementsSource;
use Psalm\Plugin\Hook\FunctionReturnTypeProviderInterface;
use Psalm\Context;
use Psalm\CodeLocation;
use PhpParser;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class RedirectHandler implements FunctionReturnTypeProviderInterface
{

    /**
     * @return array<lowercase-string>
     */
    public static function getFunctionIds(): array
    {
        return ['redirect'];
    }

    /**
     * @param  array<PhpParser\Node\Arg> $call_args
     *
     * @return ?Type\Union
     */
    public static function getFunctionReturnType(
        StatementsSource $statements_source,
        string $function_id,
        array $call_args,
        Context $context,
        CodeLocation $code_location
    ) : ?Type\Union {
        if (!$call_args) {
            return new Type\Union([
                new Type\Atomic\TNamedObject(Redirector::class)
            ]);
        }

        return new Type\Union([
            new Type\Atomic\TNamedObject(RedirectResponse::class),
        ]);
    }
}
