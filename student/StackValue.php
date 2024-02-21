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

    public function getValue(): mixed {
        return $this->value;
    }

    public function getType(): DataType {
        return $this->dataType;
    }
}
