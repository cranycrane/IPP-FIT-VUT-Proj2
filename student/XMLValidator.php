<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use IPP\Student\Exception\OpcodeNotFoundException;
use IPP\Student\Exception\UnexpectedXMLStructureException;
use IPP\Student\Factory\InstructionFactory;
use IPP\Student\Instructions\Instruction;
use UnexpectedValueException;

class XMLValidator {
    private DOMDocument $domDocument;

    /**
     * @var int[] $usedOrderNumbers
     */
    private array $usedOrderNumbers;

    public function __construct(DOMDocument $domDocument) {
        $this->domDocument = $domDocument;
        $this->usedOrderNumbers = []; 
    }

    public function validateStructure(): bool {
        $programElement = $this->domDocument->documentElement;
        if (!isset($programElement) || $programElement->nodeName !== 'program') {
            throw new UnexpectedXMLStructureException("Ocekavan hlavni element 'program'");
        }
        
        foreach ($programElement->childNodes as $instruction) {
            if ($instruction instanceof DOMElement) { // Ignorování textových uzlů
                if ($instruction->nodeName !== 'instruction') {
                    throw new UnexpectedXMLStructureException("Neočekávaný element v 'program': '{$instruction->nodeName}'");
                }
                $this->checkInstructionElement($instruction);
            }
        }

        return true;
    }

    private function checkInstructionElement(DOMElement $instruction): void {
        $attributes = $instruction->attributes;

        $orderAttr = $attributes->getNamedItem('order');
        $opcodeAttr = $attributes->getNamedItem('opcode');

        if ($attributes->length != 2) {
            throw new UnexpectedXMLStructureException("Nespravny pocet atributu u instruction");
        }
        if ($instruction->nodeType === XML_ELEMENT_NODE && $instruction->nodeName !== 'instruction') {
            throw new UnexpectedXMLStructureException("Neocekavany element: '{$instruction->nodeName}'");
        }
        if ($orderAttr == null || $opcodeAttr == null) {
            throw new UnexpectedXMLStructureException("Instruction neobsahuje 'order' nebo 'opcode");
        }
        if (!is_numeric($orderAttr->nodeValue) || \in_array($orderAttr->nodeValue, $this->usedOrderNumbers)) {
            throw new UnexpectedXMLStructureException("Neocekavana hodnota atributu 'order'");
        } 

        $this->usedOrderNumbers[] = (int)$orderAttr->nodeValue;

        $this->checkArgsElements($instruction->childNodes);
    }

    /**
     * Kontroluje, že všechny prvky v DOMNodeList jsou instance DOMElement.
     *
     * @param DOMNodeList<DOMElement> $args Seznam uzlů k ověření
     */
    private function checkArgsElements(DOMNodeList $args): void {
        $counter = 1;
        foreach ($args as $arg) {
            if (!$arg instanceof DOMElement) {
                continue;
            }

            if ($arg->nodeName !== "arg{$counter}" || !$arg instanceof DOMElement) {
                throw new UnexpectedXMLStructureException("Neocekavany nazev nebo typ elementu: '{$arg->nodeName}', ocekavany 'arg'");  
            }

            $counter++;
            $attributes = $arg->attributes;

            if ($attributes->length != 1) {
                throw new UnexpectedXMLStructureException("Nespravny pocet atributu u elementu arg");
            }

            if ($attributes->getNamedItem('type') == null) {
                throw new UnexpectedXMLStructureException("Nenalezen atribut 'type' u arg");
            }
        }
    }
}
