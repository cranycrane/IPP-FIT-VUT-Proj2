<?php

namespace IPP\Student\Instructions\Relational;

use IPP\Student\Enums\DataType;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\Variable;

abstract class RelationalInstruction extends FrameAwareInstruction {

    protected abstract function executeSpecific(): void;

    /**
     * @return array{Variable,mixed,mixed}
     */
    protected function getCheckedArgs(): array {
        $this->checkArgsCount(3);

        $args = $this->getArgs();
        
        $variable = $this->getDestVar($args[0]);
        $symbArg1 = $this->getArgValue($args[1]);
        $symbArg2 = $this->getArgValue($args[2]);

    
        if ($symbArg1->getType() != $symbArg2->getType()) {
            throw new WrongOperandTypesException("Datove typy operandu se lisi");
        }

        if ($symbArg1->getType() == DataType::Nil || $symbArg2->getType() == DataType::Nil) {
            throw new WrongOperandTypesException("Datove typy operandu se lisi");
        }

        return [$variable, $symbArg1->getValue(), $symbArg2->getValue()];
    }
}
