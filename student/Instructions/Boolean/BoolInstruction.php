<?php

namespace IPP\Student\Instructions\Boolean;

use ArgumentCountError;
use InvalidArgumentException;
use IPP\Student\Arguments\Argument;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;
use IPP\Student\Instructions\FrameAwareInstruction;

abstract class BoolInstruction extends FrameAwareInstruction {


    abstract function executeSpecific(): void;

    /**
     * @return array{Variable,bool,?bool}
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
        if (!($args[1] instanceof VarArgument || $args[1] instanceof ConstArgument)) {
            throw new ArgumentException("Druhy argument musi byt promenna nebo literal");
        }
        if (!($args[2] instanceof VarArgument || $args[2] instanceof ConstArgument)) {
            throw new ArgumentException("Treti argument musi byt promenna nebo literal");
        }

        $variable = $this->frameManager->getVariable($varArg->getFrameName(), $varArg->getName());

        $value2 = $this->getValue($args[1]);
        $value3 = $this->getValue($args[2]);

        return [$variable, $value2, $value3];
    }

    protected function getValue(Argument $argument): bool {
        if ($argument instanceof VarArgument) {
            $variable = $this->frameManager->getVariable($argument->getFrameName(), $argument->getName());

            if ($variable->getType() != DataType::Bool) {
                throw new ArgumentException("Argument musi byt typu BOOL");
            }

            $varValue = $variable->getValue();
            return $varValue;
        }

        if ($argument instanceof ConstArgument) {
            if ($argument->getDataType() != DataType::Bool) {
                throw new ArgumentException("Argument musi byt typu BOOL");
            }
            return $argument->getValue();
        } else {
            throw new ArgumentException("Argument musi byt typu BOOL");
        }
    }
}
