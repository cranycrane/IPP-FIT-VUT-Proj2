<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\Exception\UninitializedVariableException;
use IPP\Student\FrameManager;
use IPP\Student\Variable;

class TypeInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        try {
            [$variable, $symbType] = $this->getCheckedArgs();
            $value = $symbType->value;
        } catch (UninitializedVariableException $e) {
            $value = '';
        }

        $variable->setValue($value, DataType::String);
    }

    /**
     * @return array{Variable,DataType}
     */
    protected function getCheckedArgs(): array {
        $args = $this->getArgs();

        if (count($args) != 2) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);
        $symbArg = $this->getArgValue($args[1]);

        return [$variable, $symbArg->getType()];
    }

}