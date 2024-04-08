<?php

namespace IPP\Student\Arguments;

use IPP\Student\Enums\DataType;
use IPP\Student\Exception\UnexpectedArgumentException;

class TypeArgument extends Argument {
    private DataType $dataType;

    public function __construct(string $value) {
        $this->dataType = DataType::from($value);
        parent::__construct();
    }

    protected function validate(): void {
        if ($this->dataType != DataType::Int && $this->dataType != DataType::String && $this->dataType != DataType::Bool) {
            throw new UnexpectedArgumentException("Arg type nenabyva urcenych hodnot");
        }
    }

    public function getDataType(): DataType {
        return $this->dataType;
    }
}
