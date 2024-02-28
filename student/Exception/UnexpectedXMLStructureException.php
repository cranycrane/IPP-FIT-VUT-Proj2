<?php

namespace IPP\Student\Exception;

use Throwable;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class UnexpectedXMLStructureException extends IPPException
{
    public function __construct(string $message = "Unexpected XML structure", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::INVALID_SOURCE_STRUCTURE, $previous, false);
    }
}