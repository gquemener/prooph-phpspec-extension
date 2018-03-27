<?php

declare (strict_types = 1);

namespace Prooph\PhpSpec\Matcher;

use PhpSpec\Matcher\BasicMatcher;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;
use Prooph\PhpSpec\EventSourcing\AggregateExtractor;

final class RecordedEventMatcher extends BasicMatcher
{
    private $presenter;
    private $extractor;

    public function __construct(
        Presenter $presenter,
        AggregateExtractor $extractor
    ) {
        $this->presenter = $presenter;
        $this->extractor = $extractor;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return 'haveRecorded' === $name
            && 1 === \count($arguments)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($subject, array $arguments): bool
    {
        $events = $this->extractor->extractRecordedEvents($subject);

        return count(array_filter($events, function($event) use ($arguments) {
            return $arguments[0] === get_class($event);
        })) > 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFailureException(string $name, $subject, array $arguments): FailureException
    {
        return new FailureException(sprintf(
            'Expected %s to have recorded at least one %s event, but it has not.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments[0])
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
    {
        return new FailureException(sprintf(
            'Expected %s not to have recorded a %s event, but it has.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments[0])
        ));
    }
}
