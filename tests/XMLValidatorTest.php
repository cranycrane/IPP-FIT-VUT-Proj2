<?php

namespace Tests;

use DOMDocument;
use IPP\Core\Exception\XMLException;
use IPP\Student\XMLValidator;
use PHPUnit\Framework\TestCase;
use IPP\Core\FileSourceReader;
use IPP\Student\Exception\UnexpectedXMLStructureException;
use IPP\Student\Exception\OpcodeNotFoundException;

class XMLValidatorTest extends TestCase {


    public function testValidXML() {
        $filePath = __DIR__ . "/testFiles/validXML.xml";
        $fileReader = new FileSourceReader($filePath);

        $xmlValidator = new XMLValidator($fileReader->getDOMDocument());

        $result = $xmlValidator->validateStructure();

        $this->assertTrue($result);
    }

    public function testNegativeOrder() {
        $filePath = __DIR__ . "/testFiles/negativeOrder.xml";
        $fileReader = new FileSourceReader($filePath);

        $xmlValidator = new XMLValidator($fileReader->getDOMDocument());

        $this->expectException(UnexpectedXMLStructureException::class);
        $result = $xmlValidator->validateStructure();
    }

    public function testMissingProgram() {
        $filePath = __DIR__ . "/testFiles/missingProgram.xml";
        $fileReader = new FileSourceReader($filePath);

        $this->expectException(XMLException::class);
        $xmlValidator = new XMLValidator($fileReader->getDOMDocument());    
    }

    public function testBadOpcode() {
        $filePath = __DIR__ . "/testFiles/badOpcode.xml";
        $fileReader = new FileSourceReader($filePath);

        $xmlValidator = new XMLValidator($fileReader->getDOMDocument());    
        $this->expectException(OpcodeNotFoundException::class);
        $result = $xmlValidator->validateStructure();
    }

    public function testBadAttribute() {
        $filePath = __DIR__ . "/testFiles/badAttribute.xml";
        $fileReader = new FileSourceReader($filePath);

        $xmlValidator = new XMLValidator($fileReader->getDOMDocument());    
        $this->expectException(UnexpectedXMLStructureException::class);
        $result = $xmlValidator->validateStructure();
    }
}
