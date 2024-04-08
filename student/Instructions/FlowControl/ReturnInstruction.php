<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Exception\ArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Interface\CallStackAccess;
use IPP\Student\Stacks\CallStack;

class ReturnInstruction extends Instruction {

    private CallStack $callStack;

    private ExecutionContext $execContext;

    protected function executeSpecific(): void {
        $this->getCheckedArgs();
        $returnPosition = $this->callStack->pop();
        $this->execContext->instructionPointer = $returnPosition;
    }

    public function setDependency(ExecutionContext $execContext): void {
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