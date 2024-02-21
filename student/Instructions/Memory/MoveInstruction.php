<?php

namespace IPP\Student\Instructions\Memory;

use IPP\Student\Variable;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\TypedValue;

class MoveInstruction extends FrameAwareInstruction {
    
    public function executeSpecific(): void {
        [$varArg, $symbValue] = $this->getCheckedArgs();

        $varArg->setValue($symbValue->getValue(), $symbValue->getType());
    }

    /**
     * @return array{Variable,TypedValue}
     */
    public function getCheckedArgs(): array {
        $variable = $this->getDestVar($this->getArg(0));

        $value = $this->getArgValue($this->getArg(1));

        return [$variable, $value];
    }
}