<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\Arguments\ConstArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\TypedValue;

class WriteInstruction extends FrameAwareInstruction {

    private OutputWriter $outputWriter;
    
    public function setDependency(ExecutionContext $execContext) {
        parent::setDependency($execContext);
        $this->outputWriter = $execContext->outputWriter;
    }

    public function executeSpecific(): void {
        [$symbArg] = $this->getCheckedArgs();

        $this->writeDependType($symbArg->getValue(), $symbArg->getType());
    }

    /**
     * @return array{TypedValue}
     */
    protected function getCheckedArgs(): array {
        if (count($this->getArgs()) != 1) {
            throw new ArgumentCountError();
        }

        $symbVar = $this->getArgValue($this->getArg(0));

        return [$symbVar];
    }

    private function writeDependType(mixed $value, DataType $dataType) {
        if ($dataType == DataType::Bool) {
            $this->outputWriter->writeBool($value);
        }
        else if ($dataType == DataType::Int) {
            $this->outputWriter->writeInt($value);
        }
        else if ($dataType == DataType::String) {
            $this->outputWriter->writeString($value);
        }
        else if ($dataType == DataType::Nil) {
            $this->outputWriter->writeString('nil');
        }
        else {
            throw new UnexpectedArgumentException("Neocekavany datovy typ argumentu");
        }
    }
}