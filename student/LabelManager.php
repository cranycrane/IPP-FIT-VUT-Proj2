<?php

namespace IPP\Student;

use IPP\Student\Exception\UndefinedLabelException;

class LabelManager {
    private array $labels = [];

    public function registerLabel(string $name, int $position): void {
        $this->labels[$name] = $position;
    }

    public function findLabelPosition(string $name): int {
        $position = $this->labels[$name];
        if ($position == null) {
            throw new UndefinedLabelException("Navesti {$name} neexistuje");
        }
        return $this->labels[$name];
    }
}
