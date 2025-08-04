<?php

namespace Quanta\Core;
use Quanta\Quanta;

class EventHandler
{
    private $events = [];

    /**
     * Registers an event with a unique identifier and a callback function.
     *
     * @param string $eventName The name of the event to register.
     * @param callable $callback The function to call when the event is triggered.
     * @return string A unique identifier for the registered event.
     */
    public function registerEvent($eventName, callable $callback)
    {
        $eventId = uniqid("event_", true);
        if (!isset($this->events[$eventName]))
        {
            $this->events[$eventName] = [];
        }
        $this->events[$eventName][$eventId] = $callback;
        return $eventId;
    }

    /**
     * Unregisters an event using its unique identifier.
     *
     * @param string $eventName The name of the event to unregister.
     * @param string $eventId The unique identifier of the event to unregister.
     */
    public function unregisterEvent($eventName, $eventId)
    {
        if (isset($this->events[$eventName][$eventId]))
        {
            unset($this->events[$eventName][$eventId]);
        }
    }

    /**
     * Triggers an event, calling all registered callbacks with the provided arguments.
     *
     * @param Quanta $quanta The Quanta instance to pass to the callbacks.
     * @param string $eventName The name of the event to trigger.
     * @param mixed ...$args Additional arguments to pass to the callbacks.
     */
    public function triggerEvent(Quanta $quanta, $eventName, ...$args)
    {
        if (isset($this->events[$eventName]))
        {
            foreach ($this->events[$eventName] as $callback)
            {
                call_user_func($callback, $quanta, ...$args);
            }
        }
    }

    /**
     * Checks if an event is registered.
     *
     * @param string $eventName The name of the event to check.
     * @return bool True if the event is registered, false otherwise.
     */
    public function isEventRegistered($eventName)
    {
        return isset($this->events[$eventName]) && !empty($this->events[$eventName]);
    }

    /**
     * Gets all registered events.
     *
     * @return array An associative array of events with their callbacks.
     */
    public function getRegisteredEvents()
    {
        return $this->events;
    }

    /**
     * Clears all registered events.
     */
    public function clearEvents()
    {
        $this->events = [];
    }

    /**
     * Gets the number of registered events for a specific event name.
     *
     * @param string $eventName The name of the event to count.
     * @return int The number of registered events for the specified event name.
     */
    public function countEvents($eventName)
    {
        if (isset($this->events[$eventName]))
        {
            return count($this->events[$eventName]);
        }
        return 0;
    }

}