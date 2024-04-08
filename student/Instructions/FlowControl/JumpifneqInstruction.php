<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Enums\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Managers\LabelManager;

class JumpifneqInstruction extends FrameAwareInstruction {
    
    private LabelManager $labelManager;

    private ExecutionContext $execContext;

    protected function executeSpecific(): void {
        [$labelName, $value1, $value2] = $this->getCheckedArgs();

        $targetPosition = $this->labelManager->findLabelPosition($labelName);

        if ($value1 !== $value2) {
            $this->execContext->instructionPointer = $targetPosition-1;
        }
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(3);
        $labelName = $this->getLabelName();

        $arg1 = $this->getArgValue($this->getArg(1));
        $arg2 = $this->getArgValue($this->getArg(2));

        if ($arg1->getType() != $arg2->getType() && ($arg1->getType() != DataType::Nil && $arg2->getType() != DataType::Nil)) {
            throw new ArgumentException();
        }

        return [$labelName, $arg1->getValue(), $arg2->getValue()];
    }

    protected function setDependency(ExecutionContext $execContext): void {
        parent::setDependency($execContext);
        $this->labelManager = $execContext->labelManager;
        $this->execContext = $execContext;
    }

}
