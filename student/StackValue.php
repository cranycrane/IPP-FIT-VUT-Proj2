<?php

namespace IPP\Student;

use IPP\Student\Exception\MissingValueException;

class StackValue {
    private mixed $value;

    private DataType $dataType;

    public function __construct(mixed $value, DataType $dataType) {
        $this->value = $value;
        $this->dataType = $dataType;
    }

    public function getValue() {
        return $this->value;
    }

    public function getType() {
        return $this->dataType;
    }
}
