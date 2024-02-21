<?php

namespace IPP\Student\Instructions\Stack;

use ArgumentCountError;
use IPP\Student\Variable;

class PopsInstruction extends StackInstruction {


    public function executeSpecific(): void {
        [$variable] = $this->getCheckedArgs();
        $stackValue = $this->dataStack->pop();
        $variable->setValue($stackValue->getValue(), $stackValue->getType());
    }

    /**
     * @return array{Variable}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        if (count($args) != 1) {
            throw new ArgumentCountError();
        }
        $variable = $this->getDestVar($this->getArg(0));

        return [$variable];
    }

}
