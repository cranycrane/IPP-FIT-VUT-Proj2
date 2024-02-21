<?php

namespace IPP\Student;

use IPP\Student\Exception\OpcodeNotFoundException;

class InstructionMap {
    /**
     * @var string[] $map
     */
    private static $map = [
        'MOVE' => 'IPP\Student\Instructions\Memory\MoveInstruction',
        'CREATEFRAME' => 'IPP\Student\Instructions\Memory\CreateFrameInstruction',
        'PUSHFRAME' => 'IPP\Student\Instructions\Memory\PushFrameInstruction',
        'POPFRAME' => 'IPP\Student\Instructions\Memory\PopFrameInstruction',
        'DEFVAR' => 'IPP\Student\Instructions\Memory\DefvarInstruction',
        'CALL' => 'IPP\Student\Instructions\Function\CallInstruction',
        'RETURN' => 'IPP\Student\Instructions\Function\ReturnInstruction',
        'PUSHS' => 'IPP\Student\Instructions\Stack\PushsInstruction',
        'POPS' => 'IPP\Student\Instructions\Stack\PopsInstruction',
        'ADD' => 'IPP\Student\Instructions\Arithmetic\AddInstruction',
        'SUB' => 'IPP\Student\Instructions\Arithmetic\SubInstruction',
        'MUL' => 'IPP\Student\Instructions\Arithmetic\MulInstruction',
        'IDIV' => 'IPP\Student\Instructions\Arithmetic\IdivInstruction',
        'LT' => 'IPP\Student\Instructions\Relational\LtInstruction',
        'GT' => 'IPP\Student\Instructions\Relational\GtInstruction',
        'EQ' => 'IPP\Student\Instructions\Relational\EqInstruction',
        'AND' => 'IPP\Student\Instructions\Boolean\AndInstruction',
        'OR' => 'IPP\Student\Instructions\Boolean\OrInstruction',
        'NOT' => 'IPP\Student\Instructions\Boolean\NotInstruction',
        'INT2CHAR' => 'IPP\Student\Instructions\Conversion\Int2charInstruction',
        'STRI2INT' => 'IPP\Student\Instructions\Conversion\Stri2intInstruction',
        'READ' => 'IPP\Student\Instructions\IO\ReadInstruction',
        'WRITE' => 'IPP\Student\Instructions\IO\WriteInstruction',
        'CONCAT' => 'IPP\Student\Instructions\String\ConcatInstruction',
        'STRLEN' => 'IPP\Student\Instructions\String\StrlenInstruction',
        'GETCHAR' => 'IPP\Student\Instructions\String\GetcharInstruction',
        'SETCHAR' => 'IPP\Student\Instructions\String\SetcharInstruction',
        'TYPE' => 'IPP\Student\Instructions\Type\TypeInstruction',
        'LABEL' => 'IPP\Student\Instructions\FlowControl\LabelInstruction',
        'JUMP' => 'IPP\Student\Instructions\FlowControl\JumpInstruction',
        'JUMPIFEQ' => 'IPP\Student\Instructions\FlowControl\JumpifeqInstruction',
        'JUMPIFNEQ' => 'IPP\Student\Instructions\FlowControl\JumpifneqInstruction',
        'EXIT' => 'IPP\Student\Instructions\FlowControl\ExitInstruction',
    ];

    public static function getClassNameForOpcode(string $opcode): string {
        if (!array_key_exists($opcode, self::$map)) {
            throw new OpcodeNotFoundException("Neznámý opcode '$opcode'");
        }
        return self::$map[$opcode];
    }
}
