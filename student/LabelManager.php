<?php

namespace IPP\Student;

use IPP\Student\Exception\RedefinationLabelException;
use IPP\Student\Exception\UndefinedLabelException;

class LabelManager {
    /**
     * @var array<string,int>
     */
    private array $labels = [];

    /**
     * @throws RedefinationLabelException
     */
    public function registerLabel(string $name, int $position): void {
        if (isset($this->labels[$name])) {
            throw new RedefinationLabelException("Label is redefined");
        }
        $this->labels[$name] = $position;
    }

    /**
     * @throws UndefinedLabelException
     */
    public function findLabelPosition(string $name): int {
        if (!isset($this->labels[$name])) {
            throw new UndefinedLabelException("Navesti {$name} neexistuje");
        }

        return $this->labels[$name];
    }
}
