<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class VariableNotFoundException extends IPPException {
    public function __construct(string $message = "Promenna neexistuje", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::VARIABLE_ACCESS_ERROR, $previous, false);
    }
}