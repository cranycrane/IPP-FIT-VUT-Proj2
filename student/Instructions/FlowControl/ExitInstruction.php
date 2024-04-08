<?php

namespace IPP\Student\Instructions\FlowControl;

use IPP\Student\Enums\DataType;
use IPP\Student\Exception\WrongExitValueException;
use IPP\Student\Instructions\FrameAwareInstruction;

class ExitInstruction extends FrameAwareInstruction {
    
    protected function executeSpecific(): void {
        [$exitValue] = $this->getCheckedArgs();
        exit($exitValue);
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(1);

        $value = $this->getArgValue($this->getArg(0));

        if ($value->getType() != DataType::Int) {
            throw new WrongExitValueException("Neocekavany datovy typ argument, ocekavan INT");
        }

        if ($value->getValue() < 0 || $value->getValue() > 9) {
            throw new WrongExitValueException("Hodnota argumentu EXIT musi byt v intervalu 0-9");
        }

        return [$value->getValue()];
    }

}
