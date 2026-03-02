<?php

namespace BalajiDharma\LaravelComment\Exceptions;

use Exception;

class CommentException extends Exception
{
    public static function invalidUser()
    {
        return new static('Invalid user.');
    }
}
