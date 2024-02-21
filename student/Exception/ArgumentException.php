<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class ArgumentException extends IPPException {
    public function __construct(string $message = "Chyba argumentu", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::OPERAND_TYPE_ERROR, $previous, false);
    }
}