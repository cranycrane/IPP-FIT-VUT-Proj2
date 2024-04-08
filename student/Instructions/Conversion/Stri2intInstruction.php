<?php

namespace IPP\Student\Instructions\Conversion;

use ArgumentCountError;
use IPP\Student\Enums\DataType;
use IPP\Student\Exception\StringException;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\Variable;

class Stri2intInstruction extends FrameAwareInstruction {
    public function executeSpecific(): void {
        [$variable, $stringValue, $position] = $this->getCheckedArgs();

        if ($position < 0 || $position >= strlen($stringValue)) {
            throw new StringException("Index mimo rozsah řetězce");
        }

        $char = mb_substr($stringValue, $position, 1, 'UTF-8');

        $ordinalValue = mb_ord($char, 'UTF-8');

        $variable->setValue($ordinalValue, DataType::Int);
    }

    /**
     * @return array{Variable,string,int}
     */
    protected function getCheckedArgs(): array {
        if (count($this->getArgs()) != 3) {
            throw new ArgumentCountError();
        }

        $variable = $this->getDestVar($this->getArg(0));
        $string = $this->getArgValue($this->getArg(1), DataType::String);
        $position = $this->getArgValue($this->getArg(2), DataType::Int);

        return [$variable, $string->getValue(), $position->getValue()];
   
    }

}