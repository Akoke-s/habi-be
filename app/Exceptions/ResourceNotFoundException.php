<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $message ??= "We cannot find this email.";

        parent::__construct($message, $code, $previous);
    }
}
