<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\Instruction;
use IPP\Student\LabelManager;

class JumpInstruction extends Instruction {
    
    private LabelManager $labelManager;

    private ExecutionContext $execContext;

    protected function executeSpecific() {
        [$labelName] = $this->getCheckedArgs();
        $targetPosition = $this->labelManager->findLabelPosition($labelName);
        $this->execContext->instructionPointer = $targetPosition-1;
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(1);
        $labelName = $this->getLabelName();
        return [$labelName];
    }

    protected function setDependency(ExecutionContext $execContext) {
        $this->labelManager = $execContext->labelManager;
        $this->execContext = $execContext;
    }

}
