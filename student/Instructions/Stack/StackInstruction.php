<?php

namespace IPP\Student\Instructions\Stack;

use IPP\Student\DataStack;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\FrameAwareInstruction;

abstract class StackInstruction extends FrameAwareInstruction {
    protected DataStack $dataStack;

    public function setDependency(ExecutionContext $execContext): void {
        $this->dataStack = $execContext->dataStack;
        $this->frameManager = $execContext->frameManager;
    }
}
