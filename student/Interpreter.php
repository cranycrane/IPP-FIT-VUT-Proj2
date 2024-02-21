<?php

namespace IPP\Student;

use DOMDocument;
use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\NotImplementedException;
use IPP\Core\Settings;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\Exception\UnexpectedXMLStructureException;
use IPP\Student\LocalFrameStack;
use IPP\Student\Frame\GlobalFrame;
use IPP\Student\Instructions\CallInstruction;
use IPP\Student\Instructions\ControlInstruction;
use IPP\Student\Instructions\FlowControl\LabelInstruction;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Instructions\ReturnInstraction;
use IPP\Student\Instructions\ReturnInstruction;

class Interpreter extends AbstractInterpreter
{
    private ExecutionContext $execContext;

    protected function init(): void {
        parent::init();

        $this->execContext = new ExecutionContext($this->stdout, $this->input, $this->stderr);
    }

    public function execute(): int
    {
        $dom = $this->source->getDOMDocument();

        $this->validateXML($dom);

        $instructions = $this->loadInstructions($dom);

        $this->registerLabels($instructions);

        $instructionsCount = count($instructions); // Předpokládejme, že $instructions je pole všech instrukcí
        while ($this->execContext->instructionPointer < $instructionsCount) {
            $instruction = $instructions[$this->execContext->instructionPointer];
            //echo("\n\nExecuting ". get_class($instruction) . "\n\n");
            $instruction->execute($this->execContext);
            $this->execContext->instructionPointer++;
        }
        
        exit(0);
    }

    private function validateXML(DOMDocument $dom) {
        $xmlValidator = new XMLValidator($dom);
        try {
            $xmlValidator->validateStructure();
        } catch (UnexpectedXMLStructureException $exception) {
            $this->stderr->writeString($exception->getMessage());
            exit(32);
        }
    }

    private function loadInstructions(DOMDocument $dom) {
        $instructionLoader = new XMLInstructionLoader($dom);
        try {
            return $instructionLoader->loadInstructions();
        } catch (UnexpectedArgumentException $exception) {
            $this->stderr->writeString($exception->getMessage());
            exit(53); 
        }
    }

    private function registerLabels($instructions) {
        foreach ($instructions as $instruction) {
            if ($instruction instanceof LabelInstruction) {
                $this->execContext->labelManager->registerLabel($instruction->getLabelName(), $instruction->getOrder());
            }
        }
    }

    private function printInstructions($instructions) {
        foreach ($instructions as $instruction) {
            echo(\get_class($instruction) . ", position: " . $instruction->getOrder() . "\n");
        }
        exit(0);
    }

}