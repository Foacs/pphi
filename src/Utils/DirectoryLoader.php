<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 18/05/19
 * Time: 12:28
 */

namespace PPHI\Utils;

use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\WrongFileFormatException;

abstract class DirectoryLoader
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var \Directory
     */
    private $directory;

    /**
     * @var array
     */
    private $loadedElements = [];

    /**
     * DirectoryLoader constructor.
     *
     * @param string $path
     *
     * @throws DirectoryNotFoundException
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->directory = dir($path);
        if (is_null($this->directory) || $this->directory === false) {
            throw new DirectoryNotFoundException("Directory (" . $this->path . ") not found");
        }
    }

    /**
     * @throws WrongFileFormatException
     */
    public function init()
    {
        while (false !== ($entry = $this->directory->read())) {
            if (strcmp($entry, ".") != 0 && strcmp($entry, "..") != 0) {
                $filename = $this->path . DIRECTORY_SEPARATOR . $entry;
                $extension = pathinfo($filename)['extension'];
                if (in_array($extension, $this->getValidExtension())) {
                    $this->loadedElements[substr($entry, 0, -(strlen($extension) + 1))] = $this->parse($filename);
                } else {
                    throw new WrongFileFormatException("File (" . $filename . ")must be "
                        . implode("|", $this->getValidExtension()) . " file");
                }
            }
        }
    }

    /**
     * Gets the valid extension for file in the directory loaded
     *
     * @return array A array of valid extension
     */
    public abstract function getValidExtension(): array;

    /**
     * Parse a file into a loaded object
     *
     * @param string $fileName The filename of file will be parse
     *
     * @return object The result of the parsing
     */
    public abstract function parse(string $fileName);

    /**
     * @return array
     */
    public function getLoadedElements(): array
    {

        return $this->loadedElements;
    }

}