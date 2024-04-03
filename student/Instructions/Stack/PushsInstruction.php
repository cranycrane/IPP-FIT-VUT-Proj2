<?php

namespace IPP\Student\Instructions\Stack;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\TypedValue;

class PushsInstruction extends StackInstruction {


    public function executeSpecific(): void {
        [$symbArg] = $this->getCheckedArgs();
        $this->dataStack->push($symbArg);
    }

    /**
     * @return array{TypedValue}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        
        if (count($args) != 1) {
            throw new ArgumentCountError();
        }

        $symb = $this->getArgValue($this->getArg(0));

        if ($symb->getType() == DataType::Nil) {
            throw new ArgumentException("Nelze push typu 'nil' na zasobnik");
        }

        return [$symb];
    }
}
