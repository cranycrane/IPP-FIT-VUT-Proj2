<?php

namespace IPP\Student\Arguments;

use IPP\Student\Arguments\Argument;
use IPP\Student\DataType;
use IPP\Student\Exception\ArgumentException;

class LabelArgument extends Argument {
    private $value;

    public function __construct($value) {
        $this->value = $value;
        parent::__construct();
    }

    public function getValue() {
        return $this->value;
    }

    protected function validate() {
        // Validace názvu proměnné a případně rámce
        
    }
}
