<?php

namespace IPP\Student;

use IPP\Student\Exception\FrameAccessException;
use IPP\Student\Frame\TemporaryFrame;

class LocalFrameStack {
    /**
     * @var TemporaryFrame[]
     */
    private array $stack;

    public function __construct() {
        $this->stack = [];
    }

    public function pop(): void {
        if (array_pop($this->stack) == null) {
            throw new FrameAccessException("Nelze provest operaci POP na prazdnem zasobniku");
        }
    }

    public function push(TemporaryFrame $tempFrame): void {
        array_push($this->stack, $tempFrame);
    }

    public function top(): TemporaryFrame {
        return end($this->stack);
    }

}
