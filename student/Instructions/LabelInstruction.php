<?php

namespace IPP\Student\Instructions;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;

abstract class LabelInstruction extends Instruction {

    public function getLabelName() {
        $labelName = $this->getArg(0);
        if (!$labelName instanceof LabelArgument) {
            throw new UnexpectedArgumentException("Neocekavany typ argumentu");
        }
        return $labelName->getValue();
    }
}
