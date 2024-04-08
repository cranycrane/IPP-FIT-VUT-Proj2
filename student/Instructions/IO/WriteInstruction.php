<?php

namespace IPP\Student\Instructions\IO;

use ArgumentCountError;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\Enums\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Values\TypedValue;

class WriteInstruction extends FrameAwareInstruction {

    protected OutputWriter $outputWriter;
    
    public function setDependency(ExecutionContext $execContext): void {
        parent::setDependency($execContext);
        $this->outputWriter = $execContext->stdout;
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

    protected function writeDependType(mixed $value, DataType $dataType): void {
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
            $this->outputWriter->writeString('');
        }
        else {
            throw new UnexpectedArgumentException("Neocekavany datovy typ argumentu");
        }
    }
}