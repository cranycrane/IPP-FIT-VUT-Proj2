<?php

namespace IPP\Student\Instructions\IO;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Arguments\TypeArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Interface\InputAccess;

class ReadInstruction extends FrameAwareInstruction {

    private InputReader $inputReader;
    
    public function setDependency(ExecutionContext $execContext) {
        parent::setDependency($execContext);
        $this->inputReader = $execContext->stdin;
    }

    public function executeSpecific(): void {
        [$variable, $typeType] = $this->getCheckedArgs();

        $value = $this->readDependType($typeType);

        if (empty($value)) {
            $typeType = DataType::Nil;
        }

        $variable->setValue($value, $typeType);
    }

    protected function getCheckedArgs(): array {
        $variable = $this->getDestVar($this->getArg(0));

        $typeArg = $this->getArg(1);

        if (!$typeArg instanceof TypeArgument) {
            throw new UnexpectedArgumentException("Neocekavany typ argumentu");
        }

        return [$variable, $typeArg->getDataType()];
    }

    private function readDependType(DataType $dataType) {
        if ($dataType == DataType::Bool) {
            $value = $this->inputReader->readBool();
        }
        else if ($dataType == DataType::Int) {
            $value = $this->inputReader->readInt();
        }
        else if ($dataType == DataType::String) {
            $value = $this->inputReader->readString();
        }
        else {
            throw new UnexpectedArgumentException("Neocekavany datovy typ argumentu");
        }
        

        return $value;
    }
}