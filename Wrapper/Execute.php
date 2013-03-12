<?php

namespace Oridoki\WrapWrapWrapBundle\Wrapper;

/**
 * Exec Wrapper
 *
 * You shouldn't use commands like exec or cmd on your code
 * but for this times you really need it, and you are sure
 * anything is gonna be broken, use this wrapper
 *
 */
class Execute
{
    /**
     * Contains the last execution output
     * @var String
     */
    protected $_output = '';

    /**
     * Executes the given command
     * @param String $command
     */
    public function command($command)
    {
        $command = $this->escape($command);
        $this->_setOutput(shell_exec($command));
    }

    /**
     * Escape the given command
     * @param String $command
     * @return string
     */
    protected function escape($command)
    {
        return escapeshellcmd($command);
    }

    /**
     * Output setter
     * @param String $output
     */
    protected function _setOutput($output)
    {
        $this->_output = $output;
    }

    /**
     * Output getter
     * @return string
     */
    public function output()
    {
        return $this->_output;
    }
}
