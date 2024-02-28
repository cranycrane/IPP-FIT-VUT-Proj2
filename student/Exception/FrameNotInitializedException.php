<?php

namespace IPP\Student\Exception;

use Exception;
use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class FrameNotInitializedException extends IPPException {
    public function __construct(string $message = "Neinicializovany ramec", ?\Throwable $previous = null) {
        parent::__construct($message, ReturnCode::FRAME_ACCESS_ERROR, $previous, true);
    }
}