<?php

namespace Oridoki\WrapWrapWrapBundle\Wrapper;

/**
 * Wrapper for ftp
 *
 * This is a simple wrapper for functions on php ftp extension
 */
class Ftp
{
    /**
     * @var resource
     */
    protected $_resource;

    /**
     * Constructor
     */
    public function __construct()
    {
        if (!extension_loaded('ftp')) {
            throw new \Exception("PHP extension FTP is not loaded.");
        }
    }

    /**
     * wrapper for ftp functions.
     */
    public function __call($name, $args)
    {
        return $this->_functionResolve($name, $args);
    }


    /**
     * Will resolve how to work with called functions
     *
     * @param string $name
     * @param array $args
     * @return resource|Ru_Ftp
     */
    protected function _functionResolve($name, $args)
    {
        $func = $this->_getRealFunctionName($name);

        if ($this->_isConnectionFunction($func)) {

            $this->_resource = $this->_callFunction($func, $args);
            $result = $this;

        } else {

            $this->_isResource($this->_resource);
            array_unshift($args, $this->_resource);
            $result = $this->_callFunction($func, $args);

        }

        return $result;
    }


    /**
     * Put a string in remote $file_name
     */
    public function putContents($fileName, $data, $mode = FTP_ASCII)
    {
        $this->_isResource($this->_resource);

        $temp = tmpfile();
        fwrite($temp, $data);
        fseek($temp, 0);
        return $this->fput($fileName, $temp, $mode);
    }


    /**
     * Make a dir recursively
     *
     * @param string $dir
     * @throws \Exception
     */
    public function mkDirRecursive($dir)
    {
        $parts = explode('/', $dir);
        $path = '';
        while (!empty($parts)) {
            $path .= array_shift($parts);
            try {
                if ($path !== '') $this->mkdir($path);
            } catch (\Exception $e) {
                if (!$this->isDir($path)) {
                    throw new \Exception("Cannot create directory '$path'.");
                }
            }
            $path .= '/';
        }
    }

    /**
     * Delete a path recursively
     *
     * @param string $path
     */
    public function deleteRecursive($path)
    {
        foreach ((array) $this->nlist($path) as $file) {
            if ($file !== '.' && $file !== '..') {
                $toRemove = $file;
                if (strpos($file, '/') === false) {
                    $toRemove = "$path/$file";
                }
                $this->deleteRecursive($toRemove);
            }
        }
        $this->rmdir($path);
    }

    /**
     * Take a StringLikeThis and return a string_like_this
     *
     * @param string
     * @return string
     */
    protected function _camelToSnake($text)
    {
        return trim(
            preg_replace(
                '/([A-Z])/e', "strtolower('_\\1')", $text
            ),
            '_'
        );
    }


    /**
     * Call a system function
     *
     * @param string $func
     * @param array $args
     * @throws \Exception
     * @return resource
     */
    protected function _callFunction($func, $args)
    {
        return call_user_func_array($func, $args);
    }


    /**
     * Check if a given argument is a resource
     *
     * @param string $resource
     * @throws \Exception
     */
    protected function _isResource($resource)
    {
        if (!is_resource($resource)) {
            throw new \Exception(
                "Not connected to FTP server. Call connect() " .
                "or ssl_connect() first."
            );
        }
    }


    /**
     * Check if function exists
     *
     * @param $name
     * @throws \Exception
     */
    protected function _getRealFunctionName($name)
    {
        $func = 'ftp_' . $this->_camelToSnake($name);

        if (!function_exists($func)) {
            throw new \Exception("Call to undefined method Ftp::$name().");
        }

        return $func;
    }

    /**
     * Is a connection type function
     *
     * @param string $name
     * @return bool
     */
    protected function _isConnectionFunction($name)
    {
        $connectionFunctions = array('ftp_connect', 'ftp_ssl_connect', 'ftp_close');
        return (in_array($name, $connectionFunctions));
    }



}
