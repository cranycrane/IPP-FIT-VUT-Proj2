<?php

namespace IPP\Student\Instructions;

use ArgumentCountError;
use IPP\Student\Exception\ArgumentDoesntExistException;
use IPP\Student\Arguments\Argument;
use IPP\Student\Arguments\LabelArgument;
use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\ExecutionContext;

abstract class Instruction {
    private int $order;

    private array $args;

    public function __construct(int $order, array $args = []) {
        $this->order = $order;
        $this->args = $args;
    }

    public function execute(ExecutionContext $execContext) {
        $this->setDependency($execContext);
        $this->executeSpecific();
    }

    protected abstract function getCheckedArgs(): array;

    protected abstract function setDependency(ExecutionContext $execContext);

    protected abstract function executeSpecific();

    public function getOrder() {
        return $this->order;
    }

    public function getArg($index): Argument {
        if (\array_key_exists($index, $this->args)) {
            return $this->args[$index];
        }

        throw new ArgumentDoesntExistException("Argument na indexu " . $index . "neexistuje");
    }

    /**
     * @return Argument[]
     */
    public function getArgs() {
        return $this->args;
    }

    protected function checkArgsCount(int $argCount) {
        if (count($this->getArgs()) != $argCount) {
            throw new ArgumentCountError("Neocekavany pocet argumentu");
        }
    }

    /**
     * @return string
     */
    public function getLabelName() {
        $labelName = $this->getArg(0);
        if (!$labelName instanceof LabelArgument) {
            throw new UnexpectedArgumentException("Neocekavany typ argumentu");
        }
        return $labelName->getValue();
    }
}