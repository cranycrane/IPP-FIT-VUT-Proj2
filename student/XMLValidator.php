<?php

namespace IPP\Student;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use IPP\Student\Exception\OpcodeNotFoundException;
use IPP\Student\Exception\UnexpectedXMLStructureException;
use IPP\Student\Factory\InstructionFactory;
use UnexpectedValueException;

class XMLValidator {
    private DOMDocument $domDocument;

    private array $usedOrderNumbers;

    public function __construct(DOMDocument $domDocument) {
        $this->domDocument = $domDocument;
        $this->usedOrderNumbers = []; 
    }

    public function validateStructure(): bool {
        $programElement = $this->domDocument->documentElement;
        if ($programElement->nodeName !== 'program') {
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

    private function checkInstructionElement(DOMElement $instruction) {
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

        $this->usedOrderNumbers[] = $orderAttr->nodeValue;

        $this->checkArgsElements($instruction->childNodes);
    }

    private function checkArgsElements(DOMNodeList $args) {
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

            $type = $arg->getAttribute('type');
            $matchingTypeIndex = array_search($type, array_column(DataType::cases(), "value"));
            if ($matchingTypeIndex === false) {
                throw new UnexpectedXMLStructureException("Uvedeny datovy typ {$type} neexistuje");
            }
        }
    }
}
