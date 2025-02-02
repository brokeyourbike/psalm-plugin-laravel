<?php declare(strict_types=1);

namespace BrokeYourBike\LaravelPlugin\Util;

use function is_string;
use function is_object;
use function is_null;
use function get_class;
use function count;
use function class_exists;
use function array_key_exists;
use ReflectionException;
use Psalm\Type\Union;
use Psalm\Type\Atomic\TNamedObject;
use Psalm\Type\Atomic\TLiteralString;
use Psalm\NodeTypeProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use BrokeYourBike\LaravelPlugin\Providers\ApplicationProvider;

final class ContainerResolver
{
    /**
     * map of abstract to concrete class fqn
     * @var array
     * @psalm-var array<string, class-string|string>
     */
    private static $cache = [];

    /**
     * @psalm-return class-string|string|null
     */
    private static function resolveFromApplicationContainer(string $abstract): ?string
    {
        if (array_key_exists($abstract, static::$cache)) {
            return static::$cache[$abstract];
        }

        // dynamic analysis to resolve the actual type from the container
        try {
            $concrete = ApplicationProvider::getApp()->make($abstract);
        } catch (BindingResolutionException | ReflectionException $e) {
            return null;
        }

        if (is_string($concrete)) {
            // some of the path helpers actually return a string when being resolved
            $concreteClass = $concrete;
        } elseif (is_object($concrete)) {
            // normally we have an object resolved
            $concreteClass = get_class($concrete);
        } else {
            // not sure how to handle this yet
            return null;
        }

        static::$cache[$abstract] = $concreteClass;

        return $concreteClass;
    }

    /**
     * @param array<\PhpParser\Node\Arg> $call_args
     */
    public static function resolvePsalmTypeFromApplicationContainerViaArgs(NodeTypeProvider $nodeTypeProvider, array $call_args): ?Union
    {
        if (! count($call_args)) {
            return null;
        }

        $firstArgType = $nodeTypeProvider->getType($call_args[0]->value);

        if ($firstArgType && $firstArgType->isSingleStringLiteral()) {
            $abstract = $firstArgType->getSingleStringLiteral()->value;
            $concrete = static::resolveFromApplicationContainer($abstract);

            if (is_null($concrete)) {
                return null;
            }

            // todo: is there a better way to check if this is a literal class string?
            if (class_exists($concrete)) {
                return new Union([
                    new TNamedObject($concrete),
                ]);
            }

            // the likes of publicPath, which returns a literal string
            return new Union([
                new TLiteralString($concrete),
            ]);
        }

        return null;
    }
}
