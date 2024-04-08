<?php

namespace IPP\Student;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Student\Managers\FrameManager;
use IPP\Student\Managers\LabelManager;
use IPP\Student\Stacks\CallStack;
use IPP\Student\Stacks\DataStack;

class ExecutionContext {

    public int $instructionPointer;

    public FrameManager $frameManager;

    public OutputWriter $stdout;

    public OutputWriter $stderr;

    public DataStack $dataStack;

    public InputReader $stdin;

    public LabelManager $labelManager;

    public CallStack $callStack;

    public function __construct(OutputWriter $stdout,  InputReader $stdin, OutputWriter $stderr) {
        $this->frameManager = new FrameManager();
        $this->labelManager = new LabelManager();
        $this->callStack = new CallStack();
        $this->dataStack = new DataStack();
        $this->stdout = $stdout;
        $this->stdin = $stdin;
        $this->stderr = $stderr;
        
        $this->instructionPointer = 0;
    }
}
