<?php

namespace IPP\Student\Instructions\Memory;

use ArgumentCountError;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Variable;

class CreateFrameInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        $this->getCheckedArgs();
        $this->frameManager->createTempFrame();
    }

    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        if (count($args) != 0) {
            throw new ArgumentCountError("Neocekavany pocet argumentu");
        }
        return [];
    }

}