<?php


namespace App\Exceptions;


use Throwable;

class MessageException extends \Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
