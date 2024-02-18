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
use IPP\Student\Instructions\Instruction;
use IPP\Student\Instructions\ReturnInstraction;
use IPP\Student\Instructions\ReturnInstruction;

class Interpreter extends AbstractInterpreter
{
    private ExecutionContext $execContext;

    protected function init(): void {
        parent::init();
        $frameManager = new FrameManager();
        $labelManager = new LabelManager();
        $callStack = new CallStack();
        $dataStack = new DataStack();
        $this->execContext = new ExecutionContext($frameManager, $this->stdout, $dataStack, $this->input, $labelManager, $callStack);
    }

    public function execute(): int
    {
        $dom = $this->source->getDOMDocument();

        $this->validateXML($dom);

        $instructions = $this->loadInstructions($dom);

        $instructionsCount = count($instructions); // Předpokládejme, že $instructions je pole všech instrukcí
        
        while ($this->execContext->instructionPointer < $instructionsCount) {
            $instruction = $instructions[$this->execContext->instructionPointer];
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

}