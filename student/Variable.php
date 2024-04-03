<?php

namespace IPP\Student;

use IPP\Student\DataType;
use IPP\Student\Exception\UninitializedVariableException;
use IPP\Student\Exception\WrongOperandTypesException;
use IPP\Student\TypedValue;

class Variable {
    private string $name;

    private TypedValue|null $typedValue = null;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    private function isInitialized(): bool {
        if (!isset($this->typedValue)) {
            throw new UninitializedVariableException("Promenna {$this->name} neinicializovana");
        }
        return true;
    }

    public function getType() : DataType {
        $this->isInitialized();
        return $this->typedValue->getType();
    }

    public function getValue(): mixed {
        $this->isInitialized();
        return $this->typedValue->getValue();
    }

    public function setValue(mixed $value, DataType $dataType): void {
        $this->typedValue = new TypedValue($value, $dataType);
    }

    /**
     * @return TypedValue
     */
    public function getTypedValue(): TypedValue {
        $this->isInitialized();
        return $this->typedValue;
    }
}
