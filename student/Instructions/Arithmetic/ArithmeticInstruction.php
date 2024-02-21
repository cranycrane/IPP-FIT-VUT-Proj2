<?php

namespace IPP\Student\Instructions\Arithmetic;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;

abstract class ArithmeticInstruction extends FrameAwareInstruction {

    abstract function executeSpecific(): void;

    /**
     * @return array{Variable,int,int}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();

        $varArg = $args[0];

        if (count($args) != 3) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }
        if (!$varArg instanceof VarArgument) {
            throw new ArgumentException("První argument musí být proměnná");
        }
        
        $variable = $this->frameManager->getVariable($varArg->getFrameName(), $varArg->getName());

        $value2 = $this->getValue($args[1]);
        $value3 = $this->getValue($args[2]);

        return [$variable, $value2, $value3];
    }

    private function getValue($argument) {
        if ($argument instanceof VarArgument) {
            $variable = $this->frameManager->getVariable($argument->getFrameName(), $argument->getName());
            
            if ($variable->getType() != DataType::Int) {
                throw new ArgumentException("Argument musi byt typu int");    
            }
            
            $varValue = $variable->getValue();
            return $varValue;
        }


        if ($argument instanceof ConstArgument && $argument->getDataType() == DataType::Int) {
            return $argument->getValue();
        } else {
            throw new ArgumentException("Argument musi byt typu int");
        }
    }
}
