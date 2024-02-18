<?php

namespace IPP\Student;

use ArgumentCountError;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Instructions\FrameAwareInterface;
use IPP\Student\Instructions\StackInstruction;
use IPP\Student\Interface\FrameAccess;

class PopStackInstrucion extends StackInstruction {


    public function executeSpecific(): void {
        [$variable] = $this->getCheckedArgs();
        $stackValue = $this->dataStack->pop();
        $variable->setValue($stackValue->getValue(), $stackValue->getType());
    }

    /**
     * @return array{Variable}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getCheckedArgs();
        if (count($args) != 1) {
            throw new ArgumentCountError();
        }
        $variable = $this->getDestVar($this->getArg(0));

        return [$variable];
    }

}
