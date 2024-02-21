<?php

namespace IPP\Student\Arguments;

abstract class Argument {

    public function __construct() {
        $this->validate();
    }

    abstract protected function validate(): void;
}
