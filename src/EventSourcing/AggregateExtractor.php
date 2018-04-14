<?php

declare (strict_types = 1);

namespace Prooph\PhpSpec\EventSourcing;

use Prooph\EventSourcing\AggregateRoot;

final class AggregateExtractor
{
    public function extractRecordedEvents(AggregateRoot $aggregateRoot): array
    {
        $refl = new \ReflectionObject($aggregateRoot);
        $prop = $refl->getProperty('recordedEvents');
        $prop->setAccessible(true);

        return $prop->getValue($aggregateRoot);
    }
}
