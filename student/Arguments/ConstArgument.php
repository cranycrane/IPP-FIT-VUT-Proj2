<?php

namespace IPP\Student\Arguments;

use IPP\Student\Arguments\Argument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;

class ConstArgument extends Argument {
    private DataType $dataType;

    private $value;

    public function __construct(DataType $dataType, $value) {
        $this->dataType = $dataType;
        $this->value = $value;
        parent::__construct();
    }

    public function getValue() {
        if ($this->dataType == DataType::Int) {
            return (int) $this->value;
        }
        return $this->value;
    }

    public function getDataType() {
        return $this->dataType;
    }

    protected function validate() {
        // Validace názvu proměnné a případně rámce
        
    }
}
