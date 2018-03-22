<?php

declare (strict_types = 1);

namespace GQuemener\PhpSpec;

use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ServiceContainer;
use GQuemener\PhpSpec\Matcher\RecordedEventsThatMatcher;

final class Extension implements PhpSpecExtension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('gquemener.matchers.recorded_events_that', function ($c) {
            return new RecordedEventsThatMatcher($c->get('formatter.presenter'));
        }, ['matchers']);
    }
}
