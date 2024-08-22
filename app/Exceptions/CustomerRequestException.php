<?php

namespace App\Exceptions;

use Exception;

/** 
 * Class CustomerRequestException
 */
class CustomerRequestException extends Exception
{
    /**
     * CustomerRequestException constructor
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(int $code = 500, string $message = '')
    {
        parent::__construct($message, $code);
    }
}