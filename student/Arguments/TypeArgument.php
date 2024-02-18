<?php

namespace IPP\Student\Arguments;

use IPP\Student\Arguments\Argument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;
use IPP\Student\Exception\UnexpectedArgumentException;

class TypeArgument extends Argument {
    private $dataType;

    public function __construct($value) {
        $this->dataType = DataType::from($value);
        parent::__construct();
    }

    protected function validate() {
        if ($this->dataType != DataType::Int && $this->dataType != DataType::String && $this->dataType != DataType::Bool) {
            throw new UnexpectedArgumentException("Arg type nenabyva urcenych hodnot");
        }
    }

    public function getDataType() {
        return $this->dataType;
    }
}
