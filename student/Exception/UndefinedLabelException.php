<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

// 52
class UndefinedLabelException extends IPPException {
    public function __construct(string $message = "Navesti neexistuje", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::SEMANTIC_ERROR, $previous, false);
    }
}