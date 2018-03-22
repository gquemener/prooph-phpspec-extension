<?php

declare (strict_types = 1);

namespace Prooph\PhpSpec\Matcher;

use PhpSpec\Matcher\BasicMatcher;
use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\Exception\Example\FailureException;

final class RecordedEventsThatMatcher extends BasicMatcher
{
    /**
     * @var Presenter
     */
    private $presenter;

    /**
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return bool
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return 'haveRecordedEventsThat' === $name
            && 1 === \count($arguments)
            && \is_callable($arguments[0])
        ;
    }

    /**
     * @param mixed $subject
     * @param array $arguments
     *
     * @return bool
     */
    protected function matches($subject, array $arguments): bool
    {
        $refl = new \ReflectionObject($subject);
        $prop = $refl->getProperty('recordedEvents');
        $prop->setAccessible(true);
        $events = $prop->getValue($subject);

        return $arguments[0]($events);
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
    protected function getFailureException(string $name, $subject, array $arguments): FailureException
    {
        return new FailureException(sprintf(
            'Expected %s to have recorded events that %s, but it has not.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments[0])
        ));
    }

    /**
     * @param string $name
     * @param mixed  $subject
     * @param array  $arguments
     *
     * @return FailureException
     */
    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
    {
        return new FailureException(sprintf(
            'Expected %s not to have recorded events that %s, but it has.',
            $this->presenter->presentValue($subject),
            $this->presenter->presentValue($arguments[0])
        ));
    }
}
