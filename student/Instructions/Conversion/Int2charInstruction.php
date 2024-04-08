<?php

namespace IPP\Student\Instructions\Conversion;

use IPP\Student\Enums\DataType;
use IPP\Student\Exception\StringException;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\Variable;

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
            throw new StringException("Hodnota mimo rozsah 0-255");
        }

        return [$variable, $symbArg->getValue()];
   
    }

}