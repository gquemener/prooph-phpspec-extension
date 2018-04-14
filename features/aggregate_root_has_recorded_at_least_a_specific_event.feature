Feature:
  In order to ensure a specific event has been recorded during AggregateRoot lifecycle
  As a developer
  I need to be able to check recorded events collection contains a given FQCN

  Background:
    Given the config file contains:
    """
    extensions:
        Prooph\PhpSpec\Extension: ~
    """

  Scenario: Successfully match expected recorded events
    Given the spec file "spec/RecordedEvent2/HaveRecordedEventSpec.php" contains:
    """
    <?php

    namespace spec\RecordedEvent2;

    class HaveRecordedEventSpec extends \PhpSpec\ObjectBehavior
    {
        function it_has_recorded_an_event()
        {
            $this->beConstructedThrough('create', ['abc123', 'foo']);
            $this->shouldHaveRecorded(\RecordedEvent2\Created::class);
        }
    }
    """
    And the class file "src/RecordedEvent2/HaveRecordedEvent.php" contains:
    """
    <?php

    namespace RecordedEvent2;

    class HaveRecordedEvent extends \Prooph\EventSourcing\AggregateRoot
    {
        public static function create(string $id)
        {
            $self = new self();
            $self->recordThat(\RecordedEvent2\Created::occur('abc123'));

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
    And the class file "src/RecordedEvent2/Created.php" contains:
    """
    <?php

    namespace RecordedEvent2;

    class Created extends \Prooph\EventSourcing\AggregateChanged
    {
    }
    """
    When I run phpspec
    Then the suite should pass
