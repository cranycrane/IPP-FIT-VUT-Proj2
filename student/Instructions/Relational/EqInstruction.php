<?php

namespace IPP\Student\Instructions\Relational;

use IPP\Student\DataType;
use IPP\Student\Exception\WrongOperandTypesException;

class EqInstruction extends RelationalInstruction {

    public function executeSpecific(): void {
        [$variable, $value1, $value2] = $this->getCheckedArgs();

        $result = $value1 === $value2;

        $variable->setValue($result, DataType::Bool);
    }

    protected function getCheckedArgs(): array {
        $this->checkArgsCount(3);

        $args = $this->getArgs();

        $variable = $this->getDestVar($args[0]);
        $symbArg1 = $this->getArgValue($args[1]);
        $symbArg2 = $this->getArgValue($args[2]);


        if (($symbArg1->getType() != $symbArg2->getType()) && ($symbArg1->getType() != DataType::Nil && $symbArg2->getType() != DataType::Nil)) {
            throw new WrongOperandTypesException("Datove typy operandu se lisi");
        }


        return [$variable, $symbArg1->getValue(), $symbArg2->getValue()];
    }


}
