<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class ArgumentCountException extends IPPException {
    public function __construct(string $message = "Chybny pocet argumentu", ?Throwable $previous = null) {
        parent::__construct($message, ReturnCode::INVALID_SOURCE_STRUCTURE, $previous, false);
    }
}