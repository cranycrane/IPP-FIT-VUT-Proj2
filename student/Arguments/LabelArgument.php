<?php

namespace IPP\Student\Arguments;

class LabelArgument extends Argument {
    private string $value;

    public function __construct(string $value) {
        $this->value = $value;
        parent::__construct();
    }

    public function getValue(): string {
        return $this->value;
    }

    protected function validate(): void {        
    }
}
