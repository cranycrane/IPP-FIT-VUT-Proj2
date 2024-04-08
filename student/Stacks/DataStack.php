<?php

namespace IPP\Student\Stacks;

use IPP\Student\Exception\MissingValueException;
use IPP\Student\Values\TypedValue;

class DataStack {
    /**
     * @var TypedValue[] $stack 
     */
    private array $stack = [];

    public function push(TypedValue $value): void {
        array_push($this->stack, $value);
    }

    public function pop(): TypedValue {
        if (empty($this->stack)) {
            throw new MissingValueException("DataStack je prazdny");
        }
        return array_pop($this->stack);
    }
}
