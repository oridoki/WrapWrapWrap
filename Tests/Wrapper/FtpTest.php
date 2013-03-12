<?php

namespace Oridoki\WrapWrapWrapBundle\Tests\Wrapper;

use Oridoki\WrapWrapWrapBundle\Wrapper\Ftp;

class FtpTest extends \PHPUnit_Framework_TestCase
{
    public function testCallForConnection()
    {
        $o = $this->_getStub(
            '\Oridoki\WrapWrapWrapBundle\Wrapper\Ftp',
            array(
                array(
                    'method'    => '_callFunction',
                    'response'  => true
                ),
                array(
                    'method'    => '_isResource',
                    'response'  => true
                ),
                array(
                    'method'    => '_isConnectionFunction',
                    'response'  => true
                ),
                array(
                    'method'    => '_getRealFunctionName',
                    'response'  => 'supu'
                )
            )
        );

        $method = $this
            ->_setMethodAccessible(
                get_class($o), '_functionResolve'
            );

        $response = $method->invokeArgs(
            $o, array('name' => 'fake', 'args' => array())
        );

        $this->assertSame($o, $response);
    }

    public function testCallFoNonConnection()
    {
        $o = $this->_getStub(
            '\Oridoki\WrapWrapWrapBundle\Wrapper\Ftp',
            array(
                array(
                    'method'    => '_callFunction',
                    'response'  => 'supu'
                ),
                array(
                    'method'    => '_isResource',
                    'response'  => true
                ),
                array(
                    'method'    => '_isConnectionFunction',
                    'response'  => false
                ),
                array(
                    'method'    => '_getRealFunctionName',
                    'response'  => 'supu'
                )
            )
        );

        $method = $this
            ->_setMethodAccessible(
                get_class($o), '_functionResolve'
            );

        $response = $method->invokeArgs(
            $o, array('name' => 'fake', 'args' => array())
        );

        $this->assertSame('supu', $response);
    }

    /**
     * Get stubbed objects
     * @param string $className
     * @param array $methodsAndResponses array(0 => array('method' => 'x',
     * 'response' =>  'myResponse'))
     * @return type
     */
    protected function _getStub($className, $methodsAndResponses)
    {
        $methods = array();

        foreach ($methodsAndResponses as $mr) {
            $methods[] = $mr['method'];
        }

        $stub = $this->getMock(
            $className,
            $methods
        );

        foreach ($methodsAndResponses as $mr) {
            $stub->expects($this->any())
                ->method($mr['method'])
                ->will($this->returnValue($mr['response']));
        }

        return $stub;
    }


    /**
     * Make protected method validate accessible
     * @param string $className
     * @param string $methodName
     * @return \ReflectionMethod
     */
    protected static function _setMethodAccessible($className, $methodName)
    {
        $class = new \ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

}
