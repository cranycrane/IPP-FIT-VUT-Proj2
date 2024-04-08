<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class UnexpectedArgumentException extends IPPException {
    public function __construct(string $message = "Neocekavany argument", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::SEMANTIC_ERROR, $previous, false);
    }
}
