<?php

namespace IPP\Student\Instructions\Relational;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\Argument;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\Variable;
use IPP\Student\Instructions\FrameAwareInstruction;

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
            throw new WrongOperandTypesException("GT argument nesmi byt typu nil");
        }

        return [$variable, $symbArg1->getValue(), $symbArg2->getValue()];
    }

    private function getValue(Argument $argument): mixed {
        if ($argument instanceof VarArgument) {
            $variable = $this->frameManager->getVariable($argument->getFrameName(), $argument->getName());
            $varValue = $variable->getValue();
            return $varValue;
        }

        if ($argument instanceof ConstArgument) {
            if ($argument->getDataType() == DataType::Nil) {
                throw new ArgumentException("Argument nesmi byt nil");
            }
            return $argument->getValue();
        } else {
            throw new ArgumentException("Argument byt promenna nebo literal");
        }
    }    
}
