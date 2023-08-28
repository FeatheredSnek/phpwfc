<?php

namespace WFC;

use Exception;
use Throwable;

class GeneratorException extends Exception 
{
        public function __construct($message, $code = 0, Throwable $previous = null) 
        {
            parent::__construct($message, $code, $previous);
        }
}
