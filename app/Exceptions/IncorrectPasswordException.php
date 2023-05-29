<?php

namespace App\Exceptions;

use Exception;

class IncorrectPasswordException extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $message ??= "The password is not a match.";

        parent::__construct($message, $code, $previous);
    }
}
