<?php

namespace IPP\Student;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;

class ExecutionContext {

    public int $instructionPointer;

    public FrameManager $frameManager;

    public OutputWriter $outputWriter;

    public DataStack $dataStack;

    public InputReader $inputReader;

    public LabelManager $labelManager;

    public CallStack $callStack;

    public function __construct(FrameManager $frameManager, OutputWriter $outputWriter, DataStack $dataStack, 
    InputReader $inputReader, LabelManager $labelManager, CallStack $callStack) {
        $this->frameManager = $frameManager;
        $this->outputWriter = $outputWriter;
        $this->dataStack = $dataStack;
        $this->inputReader = $inputReader;
        $this->labelManager = $labelManager;
        $this->callStack = $callStack;
        $this->instructionPointer = 0;
    }
}
