<?php

namespace IPP\Student;

use IPP\Student\Exception\UndefinedLabelException;

class LabelManager {
    /**
     * @var array<string,int>
     */
    private array $labels = [];

    public function registerLabel(string $name, int $position): void {
        $this->labels[$name] = $position;
    }

    public function findLabelPosition(string $name): int {
        if (!isset($this->labels[$name])) {
            throw new UndefinedLabelException("Navesti {$name} neexistuje");
        }

        $position = $this->labels[$name];
        
        return $position;
    }
}
