<?php

namespace Quanta\Core;
use Quanta\Quanta;

abstract class Script
{
    public string $scriptId;

    abstract public function process(Quanta $quanta);
}

class InlineScript extends Script
{
    protected string $scriptContent;

    public function __construct(string $scriptId, string $scriptContent)
    {
        $this->scriptId = $scriptId;
        $this->scriptContent = $scriptContent;
    }

    public function process(Quanta $quanta)
    {
        // Process the inline script content
        return "<script id='{$this->scriptId}'>{$this->scriptContent}</script>";
    }
}