<?php

namespace IPP\Student\Arguments;

use IPP\Student\Arguments\Argument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;

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
