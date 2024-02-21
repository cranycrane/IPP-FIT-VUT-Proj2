<?php

namespace IPP\Student\Factory;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\CallStack;
use IPP\Student\DataStack;
use IPP\Student\Exception\OpcodeNotFoundException;
use IPP\Student\ExecutionContext;
use IPP\Student\FrameManager;
use IPP\Student\InstructionMap;
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
        $className = InstructionMap::getClassNameForOpcode(\strtoupper($opcode));

        $instruction = new $className($order, $args);

        return $instruction;
    }
}
