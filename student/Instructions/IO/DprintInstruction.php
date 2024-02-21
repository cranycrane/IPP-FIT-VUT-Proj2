<?php

namespace IPP\Student\Instructions\IO;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Exception\FrameAccessException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\LabelManager;

class DprintInstruction extends WriteInstruction {

    public function setDependency(ExecutionContext $execContext): void {
        parent::setDependency($execContext);
        $this->outputWriter = $execContext->stderr;
    }
}
