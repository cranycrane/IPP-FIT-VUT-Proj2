<?php

namespace IPP\Student\Factory;

use IPP\Core\Exception\InternalErrorException;
use IPP\Student\Arguments\Argument;
use IPP\Student\InstructionMap;
use IPP\Student\Instructions\Instruction;


class InstructionFactory {
    
    /**
     * @param Argument[] $args
     */
    public function createInstruction(string $opcode, int $order, array $args): Instruction {
        $className = InstructionMap::getClassNameForOpcode(\strtoupper($opcode));

        $instruction = new $className($order, $args);

        if (!$instruction instanceof Instruction) {
            throw new InternalErrorException("Ocekavan instance tridy Instruction");
        }

        return $instruction;
    }
}
