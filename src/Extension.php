<?php

declare (strict_types = 1);

namespace Prooph\PhpSpec;

use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ServiceContainer;
use Prooph\PhpSpec\Matcher\RecordedEventsThatMatcher;

final class Extension implements PhpSpecExtension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('gquemener.matchers.recorded_events_that', function ($c) {
            return new RecordedEventsThatMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
    }
}
