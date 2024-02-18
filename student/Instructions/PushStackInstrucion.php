<?php

namespace IPP\Student;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\Instructions\StackInstruction;
use IPP\Student\Interface\FrameAccess;
use IPP\Student\TypedValue;

class PushStackInstrucion extends StackInstruction {


    public function executeSpecific(): void {
        [$symbArg] = $this->getCheckedArgs();

        $this->dataStack->push($symbArg->getValue());
    }

    /**
     * @return array{TypedValue}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getCheckedArgs();
        
        if (count($args) != 1) {
            throw new ArgumentCountError();
        }

        $symb = $this->getArgValue($this->getArg(0));

        if ($symb->getType() == DataType::Nil) {
            throw new InvalidArgumentException();
        }

        return [$symb];
    }
}
