<?php

namespace Oridoki\WrapWrapWrapBundle\Wrapper;

/**
 * File Wrapper
 *
 * Use it as a wrapper to use any php native file functions.
 * Is implementing an Iterator interface, so you can use it as iterator
 */
class File implements \Iterator
{
    /**
     * Resource to opened file
     * @var resource
     */
    protected $_resource;

    /**
     * Current buffer
     * @var string
     */
    protected $_buffer = '';

    /**
     * Current position
     * @var int
     */
    protected $_position = 0;

    /**
     * Current file name
     * @var string
     */
    protected $_filename = '';


    /**
     * Constructor
     *
     * @param null $file
     * @param null $mode
     */
    public function __construct($file = null, $mode = null)
    {
        if ($file !== null && $mode !== null) {
            $this->open($file, $mode);
        }

        return $this;
    }

    /**
     * Wrapper to simulate fopen
     *
     * @param string $file
     * @param string $mode
     * @return sites\base\rules\File
     */
    public function open($file, $mode)
    {
        if (!$this->isValid($file)) {
             return null;
        }

        $this->_position = 0;
        $this->_resource = fopen($file, $mode);
        $this->_filename = $file;
        return $this->_resource;
    }

    /**
     * Get the class resource
     * @return resource
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * Wrapper to simulate fwrite
     *
     * @param string $data
     */
    public function write($data)
    {
        fwrite($this->_resource, $data);
        return $this;
    }

    /**
     * Wrapper to simulate fclose
     *
     * @return File
     */
    public function close()
    {
        $this->_position = 0;
        $this->_filename = '';
        fclose($this->_resource);
    }

    /**
     * Wrapper to simulate rename
     *
     * @param string $oldName
     * @param string $newName
     * @return boolean
     */
    public function rename($oldName, $newName)
    {
        if ($this->isValid($oldName) && $this->isValid($newName)) {
            return rename($oldName, $newName);
        }
    }

    /**
     * Truncate the file contents to a given size
     *
     * @param int $size
     * @return File
     */
    public function truncate($size = 0)
    {
        ftruncate($this->_resource, $size);
        return $this;
    }

    /**
     * Remove current | given file
     *
     * @return bool
     */
    public function unlink($file = null)
    {
        $fileToRemove = $this->_filename;
        if ($file !== null) {
            if ($this->isValid($file)) {
                $fileToRemove = $file;
            }
        }

        if ($this->exists($fileToRemove)) {
            return unlink($fileToRemove);
        }
    }


    /**
     * Check if a given filename is valid or not
     *
     * @param $filename
     * @return bool
     */
    public function isValid($filename)
    {
        if (!is_string($filename)) {
            return false;
        }

        return true;
    }


    /**
     * Check if a given filename exists on the system
     *
     * @param $filename
     * @return bool
     */
    public function exists($filename)
    {
        if ($this->isValid($filename)) {
            if (file_exists($filename)) {
                return true;
            }
            Container::getService("\kernel\Log")->addWarning(
                "Filename $filename does not exist"
            );
        }
        return false;
    }

    /**
     * Call the fgets php function
     *
     * @return string
     */
    public function gets()
    {
        return fgets($this->_resource);
    }

    /**
     * Set the iterator to the starting point
     */
    public function rewind()
    {
        $this->position = 0;
        rewind($this->_resource);
        $this->_buffer = $this->gets();
    }

    /**
     * Return the current value
     *
     * @return mixed|string
     */
    public function current()
    {
        return $this->_buffer;
    }

    /**
     * Get the current position
     *
     * @return mixed
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Read the next position
     */
    public function next()
    {
        $this->position++;
        $this->_buffer = $this->gets();
    }

    /**
     * Condition to determine if it's the end
     * of the iteration
     * @return bool
     */
    public function valid()
    {
        return ($this->_buffer !== false);
    }

    /**
     * Get file name based on resource
     * @return string
     */
    public function getFileName()
    {
        $metaData = stream_get_meta_data($this->_resource);
        if (isset($metaData["uri"])) {
            return $metaData["uri"];    
        } 
        return "";
    }
}
