<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

// 57
class ZeroDivisionException extends IPPException {
    public function __construct(string $message = "Deleni nulou", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::OPERAND_VALUE_ERROR, $previous, false);
    }
}