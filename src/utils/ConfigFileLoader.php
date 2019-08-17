<?php


namespace PPHI\utils;

use PPHI\Exception\ConfigNotFoundException;
use PPHI\Exception\WrongFileFormatException;
use function yaml_parse_file;

/**
 * Trait ConfigFileLoader
 * @package PPHI\utils
 */
trait ConfigFileLoader
{
    /**
     * Load config from a directory and
     *
     * @param string $directory The directory which contains config
     *
     * @return array Loaded config
     *
     * @throws ConfigNotFoundException If directory not found
     * @throws WrongFileFormatException If config is in wrong format (not yaml)
     */
    public function getConfig(string $directory)
    {
        $configs = [];
        $configDir = dir($directory);
        if (is_null($configDir) || $configDir === false) {
            throw new ConfigNotFoundException("Config directory (" . $directory . ") was not found.");
        }
        while (false !== ($entry = $configDir->read())) {
            if (strcmp($entry, ".") != 0 && strcmp($entry, "..") != 0 &&
                !is_dir($directory . DIRECTORY_SEPARATOR . $entry)) {
                $filename = $directory . DIRECTORY_SEPARATOR . $entry;
                $extension = pathinfo($filename)['extension'];
                if (strcmp($extension, 'yml') !== 0 && strcmp($extension, "yaml") !== 0) {
                    throw new WrongFileFormatException("data sources config file must be yaml file");
                }
                $configs[substr($entry, 0, -(strlen($extension) + 1))] = yaml_parse_file($filename);
            }
        }
        return $configs;
    }
}
