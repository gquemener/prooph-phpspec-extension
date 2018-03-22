Feature:
  In order to ensure specific events have been recorded during AggregateRoot lifecycle
  As a developer
  I need to be able to provide a callback describing what and when events must have been recorded

  Background:
    Given the config file contains:
    """
    extensions:
        GQuemener\PhpSpec\Extension: ~
    """

  Scenario: Successfully match expected recorded events
    Given the spec file "spec/HaveRecordedEventsSpec.php" contains:
    """
    <?php

    namespace spec;

    class HaveRecordedEventsSpec extends \PhpSpec\ObjectBehavior
    {
        function it_records_events()
        {
            $this->beConstructedThrough('create', ['abc123', 'foo']);
            $this->shouldHaveRecordedEventsThat(function(array $events) {
                foreach ($events as $event) {
                    if ($event instanceof \Created) {
                        return 'abc123' === $event->aggregateId() && 'foo' === $event->bar();
                    }
                }

                return false;
            });
        }
    }
    """
    And the class file "src/HaveRecordedEvents.php" contains:
    """
    <?php

    class HaveRecordedEvents extends \Prooph\EventSourcing\AggregateRoot
    {
        public static function create(string $id, string $bar)
        {
            $self = new self();
            $self->recordThat(\Created::occur('abc123', [
              'bar' => $bar
            ]));

            return $self;
        }

        protected function aggregateId(): string
        {
            return $this->id;
        }

        protected function apply(\Prooph\EventSourcing\AggregateChanged $event): void
        {
        }
    }
    """
    And the class file "src/Created.php" contains:
    """
    <?php

    class Created extends \Prooph\EventSourcing\AggregateChanged
    {
        public function bar(): string
        {
            return $this->payload['bar'];
        }
    }
    """
    When I run phpspec
    Then the suite should pass
