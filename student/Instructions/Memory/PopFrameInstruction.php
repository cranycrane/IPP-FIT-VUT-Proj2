<?php

namespace IPP\Student\Instructions\Memory;

use ArgumentCountError;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Variable;

class PopFrameInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        $this->frameManager->popFrameStack();
    }

    /**
     * @return array<null>
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        if (count($args) != 0) {
            throw new ArgumentCountError("Neocekavany pocet argumentu");
        }
        return [];
    }

}