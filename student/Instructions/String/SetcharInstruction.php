<?php

namespace IPP\Student\Instructions\String;

use ArgumentCountError;
use IPP\Student\TypedValue;
use IPP\Student\DataType;
use IPP\Student\Exception\StringException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Variable;

class SetcharInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$variable, $position, $string] = $this->getCheckedArgs();


        $result = $variable->getValue();

        $result[$position->getValue()] = $string->getValue()[0];

        $variable->setValue($result, DataType::String);
    }

    /**
     * @return array{Variable,TypedValue,TypedValue}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();
        
        if (count($args) != 3) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);

        $position = $this->getArgValue($args[1], DataType::Int);

        $string = $this->getArgValue($args[2], DataType::String);

        if ($variable->getType() != DataType::String) {
            throw new WrongOperandTypesException("Prvni argument ocekavan string");
        }

        if ($position->getValue() >= strlen($variable->getValue()) || strlen($string->getValue() == 0) || $position->getValue() < 0) {
            throw new StringException("Indexace mimo retezec nebo druhy retezec je prazdny");
        }

        if (strlen($string->getValue()) == 0) {
            throw new StringException("Treti argument SETCHAR nesmi byt prazdny retezec");
        }


        return [$variable, $position, $string];
    }

}