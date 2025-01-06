<?php
/**
 * An simple error message wich working with the bootstrap alert-danger class
 */
class ErrorMessage extends Message
{
    public $message = null;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render_message($quanta)
    {
        return "<div class='alert alert-danger'>{$this->message}</div>";
    }
}

/**
 * An simple warning class wich working with the bootstrap alert-danger class 
 */
class WarningMessage extends Message
{
    public $message = null;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render_message($quanta)
    {
        return "<div class='alert alert-warning'>{$this->message}</div>";
    }
}

/**
 * An simple success class wich working with the bootstrap alert-danger class
 */
class SuccessMessage extends Message
{
    public $message = null;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render_message($quanta)
    {
        return "<div class='alert alert-success'>{$this->message}</div>";
    }
}