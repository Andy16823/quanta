<?php
namespace Quanta\Core;

use Quanta\Quanta;
use Quanta\Core\Message;

/**
 * Handles the messages
 */
class MessageHandler
{

    /**
     * Create an new instance from the message handler
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        if (!isset($_SESSION["flash_messages"]))
        {
            $_SESSION["flash_messages"] = array();
        }
    }

    /**
     * Adds an message to the message handler
     * @param Message $message the message to add
     * @return void
     */
    public function addMessage(Quanta $quanta, Message $message)
    {
        $message->setMessageID(uniqid());
        $_SESSION["flash_messages"][$message->getMessageID()] = $message->renderMessage($quanta);
    }

    /**
     * Fetches the current messages and resets the session message storage
     * @param mixed $quanta the quanta instance
     * @return void
     */
    public function fetchMessages(Quanta $quanta)
    {
        foreach ($_SESSION["flash_messages"] as $message)
        {
            echo $message;
        }
        $_SESSION["flash_messages"] = array();
    }
}