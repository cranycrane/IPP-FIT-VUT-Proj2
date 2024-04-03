<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class WrongOperandTypesException extends IPPException {
    public function __construct(string $message = "Chybny typ argumentu", ?\Throwable $previous = null) {
        parent::__construct($message, ReturnCode::OPERAND_TYPE_ERROR, $previous, false);
    }
}