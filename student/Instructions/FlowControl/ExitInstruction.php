<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\LabelManager;

class ExitInstruction extends FrameAwareInstruction {
    
    protected function executeSpecific(): void {
        [$exitValue] = $this->getCheckedArgs();
        exit($exitValue);
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(1);

        $value = $this->getArgValue($this->getArg(0));

        if ($value->getValue() < 0 || $value->getValue() > 9) {
            throw new ArgumentException();
        }

        return [$value];
    }

}
