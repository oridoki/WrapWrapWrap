<?php

namespace Oridoki\WrapWrapWrapBundle\Tests\Wrapper;

use Oridoki\WrapWrapWrapBundle\Wrapper\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicWriting()
    {
        $filename = $this->_getTemporaryFileName();

        $file = new File($filename, 'w');
        $file->write('hola')
            ->write('que')
            ->write('tal')
            ->close();

        $content = file_get_contents($filename);
        $this->assertEquals('holaquetal', $content);

        unlink($filename);
    }


    public function testIterator()
    {
        $filename = $this->_getTemporaryFileName();

        $content = array("hola\n", "que\n", "tal");

        $file = new File($filename, 'w');
        foreach ($content as $line) {
            $file->write($line);
        }
        $file->close();

        $file->open($filename, 'r');

        $i = 0;
        foreach ($file as $key => $value) {
            $this->assertEquals($content[$i], $value);
            $this->assertEquals($i, $key);
            $i++;
        }

        $file->unlink();
        $file->close();

    }

    protected function _getTemporaryFileName()
    {
        return tempnam(sys_get_temp_dir(), time());
    }

}
