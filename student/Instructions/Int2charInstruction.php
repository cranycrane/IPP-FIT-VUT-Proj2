<?php

namespace IPP\Student\Instructions;

use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;

class Int2charInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $intValue] = $this->getCheckedArgs();

        $char = chr($intValue);

        $variable->setValue($char, DataType::String);
    }

    /**
     * @return array{Variable,int}
     */
    protected function getCheckedArgs(): array {
        $variable = $this->getDestVar($this->getArg(0));

        $symbArg = $this->getArgValue($this->getArg(1), DataType::Int);

        if ($symbArg->getValue() < 0 || $symbArg->getValue() > 255) {
            throw new InvalidArgumentException("Hodnota mimo rozsah 0-255");
        }

        return [$variable, $symbArg->getValue()];
   
    }

}