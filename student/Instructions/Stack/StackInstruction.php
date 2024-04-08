<?php

namespace IPP\Student\Instructions\Stack;

use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Stacks\DataStack;

abstract class StackInstruction extends FrameAwareInstruction {
    protected DataStack $dataStack;

    public function setDependency(ExecutionContext $execContext): void {
        $this->dataStack = $execContext->dataStack;
        $this->frameManager = $execContext->frameManager;
    }
}
