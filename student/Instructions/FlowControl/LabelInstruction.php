<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\Instruction;

class LabelInstruction extends Instruction {
    
    protected function executeSpecific(): void {
        [$labelName] = $this->getCheckedArgs();
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(1);

        $labelName = $this->getLabelName();
        return [$labelName];
    }

    protected function setDependency(ExecutionContext $execContext): void {
        
    }

}
