<?php

namespace IPP\Student\Stacks;

use IPP\Student\Exception\MissingValueException;

class CallStack {
    /**
     * @var int[] $stack Pole pozic volani
     */
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
