<?php

namespace IPP\Student;

use IPP\Student\DataType;
use IPP\Student\Exception\WrongOperandTypesException;

class TypedValue {
    protected mixed $value;

    protected DataType $dataType;

    public function __construct(mixed $value, DataType $dataType) {
        $this->dataType = $dataType;

        if ($dataType == DataType::Int) {
            $this->value = (int) $value;
        }
        else if ($dataType == DataType::Float) {
            $this->value = (float) $value;
        }
        else if ($dataType == DataType::String) {
            $this->value = (string) $value;
        }
        else if ($dataType == DataType::Nil) {
            $this->value = null;
        }
        else {
            throw new WrongOperandTypesException("Neocekavany datovy typ");
        }
    }

    public function getType() {
        return $this->dataType;
    }

    public function getValue() {
        return $this->value;
    }
}
