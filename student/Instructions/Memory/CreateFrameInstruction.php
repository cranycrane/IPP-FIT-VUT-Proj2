<?php

namespace IPP\Student\Instructions\Memory;

use ArgumentCountError;
use IPP\Student\Instructions\FrameAwareInstruction;

class CreateFrameInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        $this->getCheckedArgs();
        $this->frameManager->createTempFrame();
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