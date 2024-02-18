<?php

namespace IPP\Student\Arguments;

use IPP\Student\Arguments\Argument;
use IPP\Student\Exception\ArgumentException;

class VarArgument extends Argument {
    private string $frame;
    private string $name;

    public function __construct($value) {
        $parts = explode('@', $value, 2);
        if(count($parts) === 2) {
            $this->frame = $parts[0];
            $this->name = $parts[1];
        } else {
            $this->name = $parts[0];
        }
        
        parent::__construct();
    }

    public function getFrameName() {
        return $this->frame;
    }

    public function getName() {
        return $this->name;
    }

    protected function validate() {
        if (!\in_array($this->frame, ['LF', 'GF', 'TF'])) {
            throw new ArgumentException("Neznamy nazev ramce");
        }
        
    }
}
