<?php

namespace IPP\Student;

use DOMDocument;
use IPP\Core\AbstractInterpreter;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\Exception\UnexpectedXMLStructureException;
use IPP\Student\Instructions\CallInstruction;
use IPP\Student\Instructions\ControlInstruction;
use IPP\Student\Instructions\FlowControl\LabelInstruction;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Instructions\ReturnInstraction;
use IPP\Student\Instructions\ReturnInstruction;
use IPP\Student\XML\XMLInstructionLoader;
use IPP\Student\XML\XMLValidator;

class Interpreter extends AbstractInterpreter
{
    private ExecutionContext $execContext;

    public function execute(): int
    {
        $dom = $this->source->getDOMDocument();

        $this->validateXML($dom);

        $instructions = $this->loadInstructions($dom);

        $this->registerLabels($instructions);

        $firstInstruction = reset($instructions);

        if ($firstInstruction) {
            $this->execContext->instructionPointer = $firstInstruction->getOrder();
        }
        next($instructions);
        $arrayKeys = array_keys($instructions);
        while ($this->execContext->instructionPointer) {
            $instruction = $instructions[$this->execContext->instructionPointer];
            //echo("\n\nExecuting ". get_class($instruction) . " Order: " . $this->execContext->instructionPointer . "\n\n");
            $instruction->execute($this->execContext);
            $this->execContext->instructionPointer = $this->getNextInstructionIndex($arrayKeys, $this->execContext->instructionPointer);
        }

        exit(0);
    }

    private function validateXML(DOMDocument $dom): void
    {
        $xmlValidator = new XMLValidator($dom);
        try {
            $xmlValidator->validateStructure();
        } catch (UnexpectedXMLStructureException $exception) {
            $this->stderr->writeString($exception->getMessage());
            exit(32);
        }
    }

    /**
     * @return array<int,Instruction>
     */
    private function loadInstructions(DOMDocument $dom): array
    {
        $instructionLoader = new XMLInstructionLoader($dom);
        try {
            return $instructionLoader->loadInstructions();
        } catch (UnexpectedArgumentException $exception) {
            $this->stderr->writeString($exception->getMessage());
            exit(53);
        }
    }

    /**
     * @param Instruction[] $instructions
     */
    private function registerLabels(array $instructions): void
    {
        foreach ($instructions as $instruction) {
            if ($instruction instanceof LabelInstruction) {
                $this->execContext->labelManager->registerLabel($instruction->getLabelName(), $instruction->getOrder());
            }
        }
    }

    /**
     * @param array<int,int> $keys
     * @param int $currentPointer
     * @return int
     */
    function getNextInstructionIndex(array $keys, int $currentPointer): int
    {
        $currentIndex = array_search($currentPointer, $keys);

        if ($currentIndex !== false && $currentIndex < count($keys) - 1) {
            return $keys[$currentIndex + 1];
        }
        return 0;
    }

    protected function init(): void
    {
        parent::init();

        $this->execContext = new ExecutionContext($this->stdout, $this->input, $this->stderr);
    }
}