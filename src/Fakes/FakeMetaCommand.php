<?php

namespace Psalm\LaravelPlugin\Fakes;

class FakeMetaCommand extends \Barryvdh\LaravelIdeHelper\Console\MetaCommand
{
    /**
     * Register an autoloader the throws exceptions when a class is not found.
     *
     * @return callable
     */
    protected function registerClassAutoloadExceptions(): callable
    {
        // by default, the ide-helper throws exceptions when it cannot find a class. However it does not unregister that
        // autoloader when it is done, and we certainly do not want to throw exceptions when we are simply checking if
        // a certain class exists. We are instead changing this to be a noop.
        return function () {
        };
    }
}
