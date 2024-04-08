<?php

namespace IPP\Student\Arguments;

use IPP\Student\Enums\DataType;

class ConstArgument extends Argument {
    private DataType $dataType;

    private mixed $value;

    public function __construct(DataType $dataType, mixed $value) {
        $this->dataType = $dataType;
        $this->value = $value;
        parent::__construct();
    }

    public function getValue(): mixed {
        if ($this->dataType == DataType::Int && is_numeric($this->value)) {
            return (int) $this->value;
        }

        return $this->value;
    }
    

    public function getDataType(): DataType {
        return $this->dataType;
    }

    protected function validate(): void {        
    }
}
