<?php
namespace Quanta\Core;
use Quanta\Quanta;

/**
 * ScriptHandler class to manage scripts in the Quanta framework.
 * It allows adding, processing, and managing scripts.
 */
class ScriptHandler
{
    protected array $scripts = [];

    /**
     * Add a script to the handler.
     * @param \Quanta\Core\Script $script
     * @return void
     */
    public function addScript(Script $script)
    {
        $this->scripts[$script->scriptId] = $script;
    }

    /**
     * Get a script by its ID.
     * @param string $scriptId
     * @return \Quanta\Core\Script|null
     */
    public function getScript(string $scriptId): ?Script
    {
        return $this->scripts[$scriptId] ?? null;
    }

    /**
     * Process all scripts and return their output.
     * @param Quanta $quanta
     * @param string $url
     * @return string
     */
    public function processScripts(Quanta $quanta): string
    {
        $output = '';
        foreach ($this->scripts as $script)
        {
            $output .= $script->process($quanta);
        }
        return $output;
    }

    /**
     * Process a specific script by its ID.
     * @param Quanta $quanta
     * @param string $scriptId
     * @return string
     */
    public function processScript(Quanta $quanta, string $scriptId): string
    {
        $script = $this->getScript($scriptId);
        if ($script !== null)
        {
            return $script->process($quanta);
        }
        return '';
    }

    /**
     * Call a JavaScript function with arguments.
     * @param string $function the name of the function to call.
     * @param bool $inline whether to call the function inline or not.
     * @param mixed ...$args the arguments to pass to the function.
     * @return string
     */
    public function callFunction(string $function, bool $inline, ...$args)
    {
        if ($inline)
        {
            $argsStr = implode(', ', array_map(fn($a) => json_encode($a), $args));
            return "{$function}({$argsStr})";
        }
        else
        {
            $argsStr = implode(', ', array_map(fn($a) => json_encode($a), $args));
            return "<script>{$function}({$argsStr});</script>";
        }
    }

    /**
     * Remove a script by its ID.
     * @param string $scriptId
     * @return void
     */
    public function removeScript(string $scriptId)
    {
        unset($this->scripts[$scriptId]);
    }

    /**
     * Clear all scripts from the handler.
     * @return void
     */
    public function clearScripts()
    {
        $this->scripts = [];
    }

    /**
     * Check if a script exists by its ID.
     * @param string $scriptId
     * @return bool
     */
    public function hasScript(string $scriptId): bool
    {
        return isset($this->scripts[$scriptId]);
    }

    /**
     * Get all scripts.
     * @return array
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }
}