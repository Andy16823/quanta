<?php
namespace Quanta\Core;

/**
 * The base class for the messages
 */
abstract class Message {
    public string $messageId;

    public function setMessageID(string $messageId): void {
        $this->messageId = $messageId;
    }

    public function getMessageID(): string { 
        return $this->messageId;
    }

    public abstract function renderMessage($quanta);
}