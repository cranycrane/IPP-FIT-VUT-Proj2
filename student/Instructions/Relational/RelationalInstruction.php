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
        $args = $this->getArgs();
        
        $variable = $this->getDestVar($args[0]);
        $symbArg1 = $args[1];
        $symbArg2 = $args[2];

        if (count($args) != 3) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        if (!($symbArg1 instanceof VarArgument || $symbArg1 instanceof ConstArgument)) {
            throw new InvalidArgumentException("Druhy argument musi byt promenna nebo literal");
        }
        if (!($symbArg2 instanceof VarArgument || $symbArg2 instanceof ConstArgument)) {
            throw new InvalidArgumentException("Treti argument musi byt promenna nebo literal");            
        }
    
        if ($symbArg1->getDataType() != $symbArg2->getDataType()) {
            throw new WrongOperandTypesException("Datove typy operandu se lisi");
        }

        $value2 = $this->getValue($args[1]);
        $value3 = $this->getValue($args[2]);

        return [$variable, $value2, $value3];
    }

    private function getValue(Argument $argument): mixed {
        if ($argument instanceof VarArgument) {
            $variable = $this->frameManager->getVariable($argument->getFrameName(), $argument->getName());
            $varValue = $variable->getValue();
            return $varValue;
        }

        if ($argument instanceof ConstArgument) {
            if ($argument->getDataType() == DataType::Nil) {
                throw new InvalidArgumentException("Argument nesmi byt nil");
            }
            return $argument->getValue();
        } else {
            throw new InvalidArgumentException("Argument byt promenna nebo literal");
        }
    }    
}
