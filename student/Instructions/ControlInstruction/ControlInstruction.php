<?php

namespace IPP\Student\Instructions;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\LabelManager;

abstract class ControlInstruction extends Instruction {

    private LabelManager $labelManager;

    public function setLabelManager(LabelManager $labelManager) {
        $this->labelManager = $labelManager;
    }
    
    abstract function execute(): int;
}
