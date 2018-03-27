<?php

declare (strict_types = 1);

namespace Prooph\PhpSpec;

use PhpSpec\Extension as PhpSpecExtension;
use PhpSpec\ServiceContainer;
use Prooph\PhpSpec\Matcher;
use Prooph\PhpSpec\EventSourcing\AggregateExtractor;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

final class Extension implements PhpSpecExtension
{
    public function load(ServiceContainer $container, array $params)
    {
        $container->define('prooph.event_sourcing.aggregate_extractor', function (IndexedServiceContainer $c) {
            return new AggregateExtractor();
        });

        $container->define('prooph.matchers.recorded_events_that', function (IndexedServiceContainer $c) {
            return new Matcher\RecordedEventsThatMatcher(
                $c->get('formatter.presenter'),
                $c->get('prooph.event_sourcing.aggregate_extractor')
            );
        }, ['matchers']);

        $container->define('prooph.matchers.recorded_event', function (IndexedServiceContainer $c) {
            return new Matcher\RecordedEventMatcher(
                $c->get('formatter.presenter'),
                $c->get('prooph.event_sourcing.aggregate_extractor')
);
        }, ['matchers']);
    }
}
