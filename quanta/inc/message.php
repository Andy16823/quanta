<?php

/**
 * The base class for the messages
 */
abstract class Message {
    public string $messageId;

    public function set_message_id(string $messageId): void {
        $this->messageId = $messageId;
    }

    public function get_message_id(): string { 
        return $this->messageId;
    }

    public abstract function render_message($quanta);
}