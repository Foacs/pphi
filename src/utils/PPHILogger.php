<?php


namespace PPHI\utils;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PPHI\Exception\ConfigNotFoundException;
use PPHI\Exception\WrongFileFormatException;

/**
 * Trait Logger
 * Use to log in PPHI
 *
 * @package PPHI\logging
 * @version 0.2.0
 * @api
 * @license CeCILL-C
 * @author Foacs
 *
 */
class PPHILogger
{
    use ConfigFileLoader;
    const CONFIG_DIR = "pphi";

    /**
     * @var Logger
     */
    protected static $instance;


    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var bool
     */
    private $setUp = false;

    private $ignoreFile = false;

    /**
     * Get the logger.
     *
     * @return Logger the logger.
     */
    public static function getLogger(): Logger
    {
        $logger = self::getInstance();
        if (!$logger->setUp) {
            try {
                $logger->setup();
            } catch (ConfigNotFoundException $e) {
                $logger->logger->addError("Config file not found (pphi/config.yml)", ["class" => "PPHILogger"]);
            } catch (WrongFileFormatException $e) {
                $logger->logger->addError(
                    "Config file in wrong format, must be yaml or yml !",
                    ["class" => "PPHILogger"]
                );
            }
        }
        return $logger->logger;
    }


    /**
     * PPHILogger setup.
     *
     * @throws ConfigNotFoundException
     * @throws WrongFileFormatException
     */
    public function setup()
    {
        if ($this->ignoreFile) {
            $this->logger = new Logger("PPHI-IgnoreFile");
            $this->setUp = true;
            return;
        }
        $configs = $this->getConfig(self::CONFIG_DIR);
        if (!array_key_exists('config', $configs)) {
            $this->logger = new Logger("PPHI-NoConfig");
            $this->logger->pushHandler(new StreamHandler("logs/pphi.default.log", Logger::DEBUG));
            throw new ConfigNotFoundException("Config file (config) not found");
        }
        $path = $configs['config']['log_file_path'] ?? 'logs/pphi.log';
        $level = $configs['config']['log_level'] ?? Logger::INFO;

        $this->logger = new Logger('PPHI');
        try {
            $this->logger->pushHandler(new StreamHandler($path, $level));
        } catch (Exception $e) {
            $this->logger->addError('Unable to set the log handler', ['class' => 'PPHILogger']);
        }
        $this->setUp = true;
    }

    public static function getInstance(): PPHILogger
    {
        if (!isset(self::$instance)) {
            self::$instance = new PPHILogger();
        }
        return self::$instance;
    }

    /**
     * If true, logger doesn't print in a file.
     * Used for unit tests.
     *
     * @param bool $ignoreFile Ignore file
     */
    public function setIgnoreFile(bool $ignoreFile): void
    {
        $this->ignoreFile = $ignoreFile;
    }
}
