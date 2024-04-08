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
    
        foreach ($this->domDocument->getElementsByTagName('instruction') as $instruction) {
            $order = (int) $instruction->getAttribute('order');
            $opcode = $instruction->getAttribute('opcode');
            
            $args = $this->loadArgs($instruction->childNodes);

            $instructions[$order] = $this->instructionFactory->createInstruction($opcode, $order, $args);
        }

        ksort($instructions);
        return $instructions;
    }    

    /**
     * @param DOMNodeList<DOMElement> $args
     * @return Argument[]
     * @throws ArgumentException
     */
    private function loadArgs(DOMNodeList $args): array {
        $argArray = [];
        foreach ($args as $arg) {
            if ($arg instanceof DOMElement && strpos($arg->nodeName, 'arg') === 0) {
                $order = intval(substr($arg->nodeName, 3));
                $argType = $arg->getAttribute('type');
                $argValue = trim($arg->nodeValue);

                $argArray[$order] = ArgumentFactory::createArg($argType, $argValue);
            }
        }

        ksort($argArray);

        return array_values($argArray);
    }
}