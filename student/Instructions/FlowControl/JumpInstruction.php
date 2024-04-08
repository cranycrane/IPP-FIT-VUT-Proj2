<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Exception\UndefinedLabelException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Managers\LabelManager;

class JumpInstruction extends Instruction {
    
    private LabelManager $labelManager;

    private ExecutionContext $execContext;

    /**
     * @throws UndefinedLabelException
     * @throws UnexpectedArgumentException
     */
    protected function executeSpecific(): void {
        [$labelName] = $this->getCheckedArgs();
        $targetPosition = $this->labelManager->findLabelPosition($labelName);
        $this->execContext->instructionPointer = $targetPosition;
    }

    /**
     * @return array{string}
     * @throws UnexpectedArgumentException
     */
    protected function getCheckedArgs(): array {
        $this->checkArgsCount(1);
        $labelName = $this->getLabelName();
        return [$labelName];
    }

    protected function setDependency(ExecutionContext $execContext): void {
        $this->labelManager = $execContext->labelManager;
        $this->execContext = $execContext;
    }

}
