<?php

namespace IPP\Student\Factory;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\CallStack;
use IPP\Student\DataStack;
use IPP\Student\Exception\OpcodeNotFoundException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\ControlInstruction;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Instructions\FrameAwareInterface;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Instructions\ReadInstruction;
use IPP\Student\Instructions\StackInstruction;
use IPP\Student\Instructions\WriteInstruction;
use IPP\Student\Interface\FrameAccess;
use IPP\Student\LabelManager;

class InstructionFactory {
    
    public function createInstruction($opcode, $order, $args) {
        $className = $this->getClassNameForOpcode($opcode);

        if (!$this->isValidOpcode($opcode)) {
            throw new OpcodeNotFoundException("Neznámý opcode '$opcode'");
        }

        $instruction = new $className($order, $args);

        return $instruction;
    }

    public function isValidOpcode(string $opcode) {
        $className = $this->getClassNameForOpcode($opcode);
        return class_exists($className);
    }

    private function getClassNameForOpcode($opcode) {
        // Předpokládejme, že $opcode je vždy velkými písmeny
        return "IPP\\Student\\Instructions\\" . ucfirst(strtolower($opcode)) . "Instruction";
    }
}
