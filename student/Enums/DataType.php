<?php

namespace IPP\Student\Enums;

enum DataType: string {
    case Int = 'int';
    case String = 'string';
    case Nil = 'nil';
    case Bool = 'bool';
    case Var = 'var';
    case Float = 'float';
    case Label = 'label';
}