# Prooph PhpSpec extension

## Disclaimer

This extension IS NOT part of the Prooph project and is highly experimental.

## Installation

You will need the [Composer](http://getcomposer.org/) package manager to install this extension.

To install this package, run the following command:

```
$ composer require --dev gquemenr/prooph-phpspec-extension
```

Once, the package is install, create or edit your `.phpspec.yml` configuration file
and [register the extension](http://www.phpspec.net/en/stable/cookbook/extensions.html#configuration):

```yaml
extensions:
    Prooph\PhpSpec\Extension: ~
```

## Usage

This extension registers 2 matchers that'll help you describe the expected behaviors
of your [Prooph aggregate roots](http://docs.getprooph.org/event-sourcing/intro.html#4-1).

### `shouldHaveRecorded(string $eventClassname)`

This matcher will check if your aggregate root has recorded at least one event of the provided class.

[Example](features/aggregate_root_has_recorded_at_least_a_specific_event.feature)

### `shouldHaveRecordedEventsThat(callable $callback)`

This matcher will check that the recorded events of your aggregate root matches conditions specified in
the provided callback.

The callback has the following signature:

```
bool callback ( array $events )
```

[Example](features/aggregate_root_has_recorded_events.feature)
