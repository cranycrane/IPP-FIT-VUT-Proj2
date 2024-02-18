<?php

namespace IPP\Student\Instructions;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\CallStack;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Interface\CallStackAccess;
use IPP\Student\Variable;

class ReturnInstruction extends Instruction {

    private CallStack $callStack;

    private ExecutionContext $execContext;

    protected function executeSpecific() {
        $this->getCheckedArgs();
        $returnPosition = $this->callStack->pop();
        $this->execContext->instructionPointer = $returnPosition;
    }

    public function setDependency(ExecutionContext $execContext) {
        $this->callStack = $execContext->callStack;
        $this->execContext = $execContext;
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        if (count($args) != 0) {
            throw new ArgumentException("Neocekavany pocet argumentu");
        }
        return [];
    }

}