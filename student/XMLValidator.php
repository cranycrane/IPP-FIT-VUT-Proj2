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
        if (!is_numeric($orderAttr->nodeValue) || \in_array($orderAttr->nodeValue, $this->usedOrderNumbers) || (int)$orderAttr->nodeValue < 1) {
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
        $argOrder = [];
        foreach ($args as $arg) {
            if (!$arg instanceof DOMElement) {
                continue;
            }

            $order = intval(substr($arg->nodeName, 3));
            if (array_key_exists($order, $argOrder)) {
                throw new UnexpectedXMLStructureException("Duplicitní pořadí argumentu: '{$order}'");
            }

            $argOrder[$order] = $arg;

            $attributes = $arg->attributes;
            if ($attributes->length != 1 || $attributes->getNamedItem('type') == null) {
                throw new UnexpectedXMLStructureException("Nesprávný počet atributů nebo chybějící atribut 'type' u arg");
            }

            $this->checkArgValue($arg);
        }

        ksort($argOrder);
        $expectedOrder = 1;
        foreach ($argOrder as $order => $arg) {
            if ($order != $expectedOrder) {
                throw new UnexpectedXMLStructureException("Neočekávané nebo chybějící pořadí argumentu. Očekáváno: '{$expectedOrder}', zjištěno: '{$order}'");
            }
            $expectedOrder++;
        }
    }

    private function checkArgValue(DOMElement $arg): void {
        $type = $arg->getAttribute('type');
        $value = trim($arg->nodeValue);

        switch ($type) {
            case 'int':
                if (!is_numeric($value) || intval($value) != $value) {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'int'.");
                }
                break;
            case 'string':
                $regex = '/(?:[^\s#\\\\]|\\\\[0-9]{3})*$/';
                if (!preg_match($regex, $value)) {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'string'.");
                }
                break;
            case 'bool':
                if ($value !== 'true' && $value !== 'false') {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'bool'.");
                }
                break;
            case 'var':
                $regex = '/(LF|TF|GF)@[A-Za-z_$&%*!?-][A-Za-z0-9_$&%*!?-]*$/';
                if (!preg_match($regex, $value)) {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'var'.");
                }
                break;
            case 'nil':
                if ($value !== 'nil') {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'var'.");
                }
                break;
            case 'label':
                $regex = '/[A-Za-z_$&%*!?-][A-Za-z0-9_$&%*!?-]*$/';
                if (!preg_match($regex, $value)) {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'var'.");
                }
                break;
            case 'type':
                $regex = '/string|int|bool|nil/';
                if (!preg_match($regex, $value)) {
                    throw new UnexpectedXMLStructureException("Hodnota argumentu '$value' neodpovida typu 'var'.");
                }
                break;
            default:
                throw new UnexpectedXMLStructureException("Neznámý typ argumentu '$type'.");
        }
    }

}
