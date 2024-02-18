<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\Factory\ArgumentFactory;
use IPP\Student\Factory\InstructionFactory;

class XMLInstructionLoader {
    protected DOMDocument $domDocument;
    protected InstructionFactory $instructionFactory;

    public function __construct(DOMDocument $domDocument) {
        $this->domDocument = $domDocument;
        $this->instructionFactory = new InstructionFactory();
    }

    /**
     * @return Instruction[]
     */
    public function loadInstructions() {
        $instructions = [];
    
        // Načtení instrukcí do pole
        foreach ($this->domDocument->getElementsByTagName('instruction') as $instruction) {
            $order = (int) $instruction->getAttribute('order'); // Převedení na int pro správné řazení
            $opcode = $instruction->getAttribute('opcode');
            
            $args = $this->loadArgs($instruction->childNodes);

            $instructions[$order] = $this->instructionFactory->createInstruction($opcode, $order, $args);
        }
    
        // Setřídění instrukcí podle klíče 'order'
        ksort($instructions);
    
        return array_values($instructions); // Vrátí setříděné instrukce s resetovanými indexy
    }    

    private function loadArgs(DOMNodeList $args) {
        $argArray = [];
        foreach ($args as $arg) {
            if ($arg instanceof DOMElement && strpos($arg->nodeName, 'arg') === 0) {
                $argType = $arg->getAttribute('type');
                $argValue = $arg->nodeValue;
                $argArray[] = ArgumentFactory::createArg($argType, $argValue);
            }
        }
        return $argArray;
    }
    
}