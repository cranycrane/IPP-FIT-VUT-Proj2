<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\Exception\UninitializedVariableException;
use IPP\Student\FrameManager;
use IPP\Student\TypedValue;
use IPP\Student\Variable;

class TypeInstruction extends FrameAwareInstruction
{

    public function executeSpecific(): void
    {
        [$variable, $value] = $this->getCheckedArgs();

        $variable->setValue($value, DataType::String);
    }

    /**
     * @return array{Variable,string}
     * @todo v symbArg muze byt neinicializovana promenna - zjistit jak vyresit
     */
    protected function getCheckedArgs(): array
    {
        $args = $this->getArgs();

        if (count($args) != 2) {
            throw new ArgumentCountError("Nesprávný počet argumentů");
        }

        $variable = $this->getDestVar($args[0]);

        try {
            $symbArgValue = $this->getArgValue($args[1])->getType()->value;
        } catch (UninitializedVariableException $e) {
            $symbArgValue = '';
        }

        return [$variable, $symbArgValue];
    }

}