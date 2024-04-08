<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Interface\CallStackAccess;
use IPP\Student\Interface\DataStackAccess;
use IPP\Student\Managers\LabelManager;
use IPP\Student\Stacks\CallStack;

class CallInstruction extends Instruction {

    private CallStack $callStack;

    private LabelManager $labelManager;

    private ExecutionContext $execContext;

    public function executeSpecific(): void {
        [$labelName] = $this->getCheckedArgs();
        $targetPosition = $this->labelManager->findLabelPosition($labelName);
        $this->callStack->push($this->getOrder());

        $this->execContext->instructionPointer = $targetPosition;
    }

    protected function setDependency(ExecutionContext $execContext): void {
        $this->callStack = $execContext->callStack;
        $this->labelManager = $execContext->labelManager;
        $this->execContext = $execContext;
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        $label = $args[0];

        if (count($args) != 1) {
            throw new ArgumentException("Neocekavany pocet argumentu");
        }
        if (!$label instanceof LabelArgument) {
            throw new ArgumentException("Neocekavany typ argumentu");
        }

        return [$label->getValue()];
    }

}