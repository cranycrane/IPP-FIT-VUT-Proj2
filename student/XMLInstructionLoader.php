<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Factory\ArgumentFactory;
use IPP\Student\Factory\InstructionFactory;
use IPP\Student\Arguments\Argument;

class XMLInstructionLoader {
    protected DOMDocument $domDocument;
    protected InstructionFactory $instructionFactory;

    public function __construct(DOMDocument $domDocument) {
        $this->domDocument = $domDocument;
        $this->instructionFactory = new InstructionFactory();
    }

    /**
     * @return array<int,Instruction>
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
        return $instructions;
        //return array_values($instructions); // Vrátí setříděné instrukce s resetovanými indexy
    }    

    /**
     * @return Argument[]
     * @throws ArgumentException
     */
    private function loadArgs(DOMNodeList $args): array {
        $argArray = [];
        foreach ($args as $arg) {
            if ($arg instanceof DOMElement && strpos($arg->nodeName, 'arg') === 0) {
                $order = intval(substr($arg->nodeName, 3)); // Extrahuje pořadové číslo z názvu uzlu (např. "arg1" -> 1)
                $argType = $arg->getAttribute('type');
                $argValue = trim($arg->nodeValue);

                // Přidá objekt Argument společně s jeho pořadovým číslem do pole
                $argArray[$order] = ArgumentFactory::createArg($argType, $argValue);
            }
        }

        // Seřadí pole podle klíčů (pořadových čísel), aby byly argumenty ve správném pořadí
        ksort($argArray);

        return array_values($argArray); // Vrátí pouze hodnoty pole, což jsou instance Argument
    }
}