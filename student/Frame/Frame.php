<?php

namespace IPP\Student\Frame;


use IPP\Student\Exception\VariableAlreadyDeclaredException;
use IPP\Student\Exception\VariableNotFoundException;
use IPP\Student\Values\Variable;

abstract class Frame {
    /**
     * @var Variable[]
     */
    protected array $variables = [];

    public function __construct() {
        $this->variables = [];
    }

    /**
     * Vrací hodnotu proměnné s daným názvem.
     * Pokud proměnná neexistuje, vyvolá výjimku.
     *
     * @param string $name Název proměnné.
     * @return Variable Instance proměnné.
     */
    public function getVariable(string $name): Variable {
        if (!$this->hasVariable($name)) {
            throw new VariableNotFoundException("Proměnná '{$name}' nebyla nalezena.");
        }

        return $this->variables[$name];
    }

    public function declareVariable(Variable $variable): void {
        if (array_key_exists($variable->getName(), $this->variables)) {
            throw new VariableAlreadyDeclaredException("Promenna jiz byla deklarovana");
        }
        $this->variables[$variable->getName()] = $variable;
    }


    /**
     * Kontroluje, zda proměnná s daným názvem existuje.
     *
     * @param string $name Název proměnné.
     * @return bool Vrací true, pokud proměnná existuje, jinak false.
     */
    public function hasVariable(string $name): bool {
        return array_key_exists($name, $this->variables);
    }

}
