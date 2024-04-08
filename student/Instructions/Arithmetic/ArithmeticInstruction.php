<?php

namespace IPP\Student\Instructions\Arithmetic;

use IPP\Student\Arguments\Argument;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Enums\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\Variable;

abstract class ArithmeticInstruction extends FrameAwareInstruction {

    abstract function executeSpecific(): void;

    /**
     * @return array{Variable,int,int}
     */
    protected function getCheckedArgs(): array {
        $this->checkArgsCount(3);

        $args = $this->getArgs();

        $varArg = $args[0];

        if (!$varArg instanceof VarArgument) {
            throw new ArgumentException("První argument musí být proměnná");
        }

        $variable = $this->getDestVar($varArg);
        $value2 = $this->getValue($args[1]);
        $value3 = $this->getValue($args[2]);

        return [$variable, $value2, $value3];
    }

    private function getValue(Argument $argument): int {
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
