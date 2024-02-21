<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class VariableAlreadyDeclaredException extends IPPException {
    public function __construct(string $message = "Prommena jiz byla deklarovana", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::SEMANTIC_ERROR, $previous, false);
    }
}