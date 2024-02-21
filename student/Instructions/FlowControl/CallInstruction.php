<?php

namespace IPP\Student\Instructions\FlowControl;

use InvalidArgumentException;
use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\CallStack;
use IPP\Student\DataStack;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Interface\CallStackAccess;
use IPP\Student\Interface\DataStackAccess;
use IPP\Student\LabelManager;
use IPP\Student\Variable;

class CallInstruction extends Instruction {

    private CallStack $callStack;

    private LabelManager $labelManager;

    private ExecutionContext $execContext;

    public function executeSpecific() {
        [$labelName] = $this->getCheckedArgs();

        $targetPosition = $this->labelManager->findLabelPosition($labelName);
        $this->callStack->push($this->getOrder() + 1);

        $this->execContext->instructionPointer = $targetPosition;
    }

    protected function setDependency(ExecutionContext $execContext) {
        $this->callStack = $execContext->callStack;
        $this->labelManager = $execContext->labelManager;
        $this->execContext = $execContext;
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        $label = $args[0];

        if (count($args) != 1) {
            throw new InvalidArgumentException("Neocekavany pocet argumentu");
        }
        if (!$label instanceof LabelArgument) {
            throw new InvalidArgumentException("Neocekavany typ argumentu");
        }

        return [$label->getValue()];
    }

}