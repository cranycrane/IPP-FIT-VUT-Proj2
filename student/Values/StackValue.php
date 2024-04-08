<?php

namespace IPP\Student\Values;

use IPP\Student\Enums\DataType;

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
