<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

// 52
class RedefinationLabelException extends IPPException {
    public function __construct(string $message = "Navesti jiz existuje", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::SEMANTIC_ERROR, $previous, false);
    }
}