<?php

namespace IPP\Student;

enum DataType: string {
    case Int = 'int';
    case String = 'string';
    case Nil = 'nil';
    case Bool = 'bool';
    case Var = 'var'; // zrejme odstranit
    case Float = 'float';
}
