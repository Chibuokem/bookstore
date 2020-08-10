<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotSavedException extends HttpException
{
    public function __construct(string $message = 'Not saved!')
    {
        parent::__construct(500, $message);
    }
}
