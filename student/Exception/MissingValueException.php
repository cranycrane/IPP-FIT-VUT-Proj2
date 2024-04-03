<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

// 56
class MissingValueException extends IPPException {

    public function __construct(string $message = "Chybna hodnota", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::VALUE_ERROR, $previous, false);
    }

}