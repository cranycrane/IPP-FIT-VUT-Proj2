<?php

namespace IPP\Student\Instructions\Memory;

use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\UnexpectedArgumentException;
use IPP\Student\FrameManager;
use IPP\Student\Instructions\FrameAwareInstruction;
use IPP\Student\Variable;

class DefvarInstruction extends FrameAwareInstruction {

    public function executeSpecific(): void {
        [$varArg] = $this->getCheckedArgs();
        
        $variable = new Variable($varArg->getName());
        
        $this->frameManager->declareVariable($varArg->getFrameName(), $variable);
    }

    /**
     * @return array{VarArgument}
     */
    public function getCheckedArgs(): array {
        $this->checkArgsCount(1);
        $varArg = $this->getArg(0);

        if (!$varArg instanceof VarArgument) {
            throw new UnexpectedArgumentException("Ocekavan argument typu var");
        }


        return [$varArg];
    }

}