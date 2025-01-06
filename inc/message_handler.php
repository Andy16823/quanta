<?php 
namespace Quanta;

/**
 * Handles the messages
 */
class MessageHandler {

    /**
     * Create an new instance from the message handler
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        $_SESSION["flash_messages"] = array();
    }

    /**
     * Adds an message to the message handler
     * @param Message $message the message to add
     * @return void
     */
    public function add_message(Message $message) { 
        $message->set_message_id(uniqid());
        $_SESSION["flash_messages"][$message->get_message_id()] = $message;
    }

    /**
     * Fetches the current messages and resets the session message storage
     * @param mixed $quanta the quanta instance
     * @return void
     */
    public function fetch_messages($quanta) {
        foreach ($_SESSION["flash_messages"] as $message) {
            echo $message->render_message($quanta);
        }
        $_SESSION["flash_messages"] = array();
    }
}