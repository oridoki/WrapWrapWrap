<?php

namespace Oridoki\WrapWrapWrapBundle\Tests\Wrapper;

use Oridoki\WrapWrapWrapBundle\Wrapper\Execute;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $expectation = 'supu';

        $execute = new Execute();
        $execute->command("echo '{$expectation}'");
        $this->assertEquals($expectation, trim($execute->output()));
    }
}
