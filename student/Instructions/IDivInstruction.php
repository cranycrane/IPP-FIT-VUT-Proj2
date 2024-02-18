<?php

namespace IPP\Student\Instructions;

use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\Exception\ZeroDivisionException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;

class IDivInstruction extends ArithmeticInstruction {


    public function executeSpecific(): void {
        [$dest, $op1, $op2] = $this->getCheckedArgs();

        if ($op2 == 0) {
            throw new ZeroDivisionException("Nelze delit nulou!");
        }

        $result = intdiv($op1,$op2);
        
        $dest->setValue($result, DataType::Int);
    }

}