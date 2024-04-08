<?php

namespace IPP\Student\Instructions\IO;

use IPP\Student\ExecutionContext;

class DprintInstruction extends WriteInstruction {

    public function setDependency(ExecutionContext $execContext): void {
        parent::setDependency($execContext);
        $this->outputWriter = $execContext->stderr;
    }
}
