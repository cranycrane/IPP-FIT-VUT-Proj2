<?php

namespace IPP\Student\Instructions;

use IPP\Student\Arguments\Argument;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Interface\FrameAccess;
use IPP\Student\TypedValue;
use IPP\Student\Variable;
use PhpParser\Node\Expr\Instanceof_;

abstract class FrameAwareInstruction extends Instruction {
    protected FrameManager $frameManager;

    protected function setDependency(ExecutionContext $execContext): void {
        $this->frameManager = $execContext->frameManager;
    }

    protected function getDestVar(Argument $arg): Variable {
        if (!$arg instanceof VarArgument) {
            throw new ArgumentException("Ocekavat argument typu promenne");
        }

        $variable = $this->frameManager->getVariable($arg->getFrameName(), $arg->getName());
        return $variable;
    }

    protected function getArgValue(Argument $arg, DataType $type = null): TypedValue {

        if ($arg instanceof VarArgument) {
            $variable = $this->frameManager->getVariable($arg->getFrameName(), $arg->getName());
            $typedValue = $variable->getTypedValue();
        }
        else if ($arg instanceof ConstArgument) {
            $value = $arg->getValue();
            $valueType = $arg->getDataType();
            $typedValue = new TypedValue($value, $valueType);
        }
        else {
            throw new ArgumentException("Ocekavan argument typu promenne nebo literal");
        }

        if ($type != null && $typedValue->getType() != $type) {
            throw new WrongOperandTypesException("Neocekavany datovy typ argumentu");
        }

        return $typedValue;
    }

}
