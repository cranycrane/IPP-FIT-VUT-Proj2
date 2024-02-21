<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\LabelManager;

class JumpifeqInstruction extends FrameAwareInstruction {
    
    private LabelManager $labelManager;

    private ExecutionContext $execContext;

    protected function executeSpecific(): void {
        [$labelName, $value1, $value2] = $this->getCheckedArgs();

        if ($value1 == $value2) {
            $targetPosition = $this->labelManager->findLabelPosition($labelName);
            $this->execContext->instructionPointer = $targetPosition-1;
        }
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(3);
        $labelName = $this->getLabelName();

        $arg1 = $this->getArgValue($this->getArg(1));
        $arg2 = $this->getArgValue($this->getArg(2));

        if ($arg1->getType() == DataType::Nil || $arg2->getType() == DataType::Nil) {
            throw new ArgumentException();
        }

        if ($arg1->getType() != $arg2->getType()) {
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
