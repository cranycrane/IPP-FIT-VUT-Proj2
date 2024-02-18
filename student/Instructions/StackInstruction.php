<?php

namespace IPP\Student\Instructions;

use IPP\Student\DataStack;
use IPP\Student\ExecutionContext;

abstract class StackInstruction extends FrameAwareInstruction {
    protected DataStack $dataStack;

    public function setDependency(ExecutionContext $execContext): void {
        $this->dataStack = $execContext->dataStack;
        $this->frameManager = $execContext->frameManager;
    }
}
