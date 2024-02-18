<?php

namespace IPP\Student;

use Exception;
use IPP\Student\Exception\MissingValueException;

class CallStack {
    private array $stack = [];

    public function push(int $position): void {
        $this->stack[] = $position;
    }

    public function pop(): ?int {
        if (empty($this->stack)) {
            throw new MissingValueException("Callstack je prazdny");
        }
        return array_pop($this->stack);
    }
}
