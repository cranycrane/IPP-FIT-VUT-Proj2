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

        //var_dump($instructions);
        $firstInstruction = reset($instructions);

        if ($firstInstruction) {
            $this->execContext->instructionPointer = $firstInstruction->getOrder();
        }
        next($instructions);
        $arrayKeys = array_keys($instructions); // Předpokládejme, že $instructions je pole všech instrukcí
        while ($this->execContext->instructionPointer) {
            $instruction = $instructions[$this->execContext->instructionPointer];
            //echo("\n\nExecuting ". get_class($instruction) . " Order: " . $this->execContext->instructionPointer . "\n\n");
            $instruction->execute($this->execContext);
            $this->execContext->instructionPointer = $this->getNextInstructionIndex($arrayKeys, $this->execContext->instructionPointer);
        }
        
        exit(0);
    }

    /**
     * @param array<int,int> $keys
     * @param int $currentPointer
     * @return int
     */
    function getNextInstructionIndex(array $keys, int $currentPointer): int {
        // Najde index aktuálního instructionPointer v seznamu klíčů
        $currentIndex = array_search($currentPointer, $keys);

        // Pokud není na poslední pozici, vrátí klíč následujícího prvku
        if ($currentIndex !== false && $currentIndex < count($keys) - 1) {
            return $keys[$currentIndex + 1];
        }

        // Jinak vrátí aktuální instructionPointer (pokud už není kam jít)
        return 0;
    }

    private function validateXML(DOMDocument $dom): void {
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
    private function loadInstructions(DOMDocument $dom): array {
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
    private function registerLabels(array $instructions): void {
        foreach ($instructions as $instruction) {
            if ($instruction instanceof LabelInstruction) {
                $this->execContext->labelManager->registerLabel($instruction->getLabelName(), $instruction->getOrder());
            }
        }
    }

    /**
     * @param Instruction[] $instructions
     */
    private function printInstructions(array $instructions): void {
        foreach ($instructions as $instruction) {
            echo(\get_class($instruction) . ", position: " . $instruction->getOrder() . "\n");
        }
        exit(0);
    }

}