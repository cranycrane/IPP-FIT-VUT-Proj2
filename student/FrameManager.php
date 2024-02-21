<?php

namespace IPP\Student;

use IPP\Student\Arguments\VarArgument;
use IPP\Student\Exception\FrameAccessException;
use IPP\Student\Exception\FrameNotInitializedException;
use IPP\Student\Frame\Frame;
use IPP\Student\Frame\GlobalFrame;
use IPP\Student\Frame\TemporaryFrame;

class FrameManager {

    private GlobalFrame $globalFrame;

    private LocalFrameStack $localFrameStack;

    private TemporaryFrame $tempFrame;

    public function __construct() {
        $this->globalFrame = new GlobalFrame();
        $this->localFrameStack = new LocalFrameStack();
    }

    public function createTempFrame() {
        $this->tempFrame = new TemporaryFrame();
    }

    public function pushFrameStack() {
        if (!isset($this->tempFrame)) {
            throw new FrameAccessException("Frame not created");
        }
        $this->localFrameStack->push($this->tempFrame);
    }

    public function popFrameStack() {
        $this->localFrameStack->pop();
    }

    public function declareVariable(string $frameName, Variable $variable) {
        $frame = $this->getFrame($frameName);
        $frame->declareVariable($variable);
    }

    public function setVariable(string $frameName, string $varName, mixed $value, DataType $dataType) {
        $frame = $this->getFrame($frameName);
        $frame->getVariable($varName)->setValue($value, $dataType);
    }

    public function getVariable(string $frameName, string $name) {
        $frame = $this->getFrame($frameName);
        return $frame->getVariable($name);
    }

    private function getFrame(string $frameId): Frame {
        switch ($frameId) {
            case 'GF':
                return $this->globalFrame;
            case 'LF':
                return $this->localFrameStack->top();
            case 'TF':
                if ($this->tempFrame == null) {
                    throw new FrameNotInitializedException("Docasny ramec nebyl inicializovan");
                }
                return $this->tempFrame;
            default:
                throw new FrameAccessException("Neznámý identifikátor rámce '{$frameId}'.");
        }
    }

}
