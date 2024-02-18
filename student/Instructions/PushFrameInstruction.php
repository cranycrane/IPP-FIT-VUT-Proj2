<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;

class PushFrameInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        $this->frameManager->pushFrameStack();
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        if (count($args) != 0) {
            throw new ArgumentCountError("Neocekavany pocet argumentu");
        }
        return [];
    }
}