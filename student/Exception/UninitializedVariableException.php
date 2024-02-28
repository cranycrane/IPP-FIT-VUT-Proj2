<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class UninitializedVariableException extends IPPException {
    public function __construct(string $message = "Neinicializovana promenna", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::VALUE_ERROR, $previous, true);
    }
}