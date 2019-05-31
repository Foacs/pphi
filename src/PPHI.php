<?php

namespace PPHI;

use PPHI\DataSource\DataSourceManager;
use PPHI\Entity\EntityManager;
use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\entity\EntityFormatException;
use PPHI\Exception\WrongFileFormatException;
use PPHI\Listener\InitListener;
use PPHI\Listener\LoadListener;
use PPHI\Utils\Singleton;

/**
 * Class PPHI
 * @package PPHI
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.1.0-alpha First time this was introduced
 * @since 0.2.0-alpha New sequence
 */
class PPHI
{
    use Singleton;
    const VERSION = "0.1.0";

    const DATA_SOURCES_PATH = "pphi/datasources";
    const ENTITY_DIRECTORY_PATH = "entities";
    const ENTITY_NAMESPACE = "PPHI\\FunctionalTest\\entities\\";

    /**
     * @var DataSourceManager
     */
    private $dataSourcesManager;


    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Initialise manager
     * Load file for manager
     *
     * @throws DirectoryNotFoundException
     * @throws Exception\datasource\DataSourceDirectoryNotFoundException
     */
    public function preInit(): void
    {
        $this->dataSourcesManager = new DataSourceManager(self::DATA_SOURCES_PATH);
        $this->connectionManager = new ConnectionManager();
        $this->entityManager = new EntityManager(self::ENTITY_DIRECTORY_PATH, self::ENTITY_NAMESPACE);
    }

    public function init(InitListener $listener): void
    {
        try {
            $this->dataSourcesManager->init();
            $this->connectionManager->init($this->dataSourcesManager);
            $this->entityManager->init();
        } catch (WrongFileFormatException $e) {
            $listener->onException($e);
        }
        $listener->onComplete();
    }

        $this->dataSourcesManager = new DataSourceManager();
        $this->connectionManager = new ConnectionManager();
        $dataSourcesDir = dir(self::DATA_SOURCES_PATH);
        if (is_null($dataSourcesDir) || $dataSourcesDir === false) {
            throw new ConfigNotFoundException("Data sources (pphi/datasources) config directory not found");
        }
        while (false !== ($entry = $dataSourcesDir->read())) {
            if (strcmp($entry, ".") != 0 && strcmp($entry, "..") != 0) {
                $filename = self::DATA_SOURCES_PATH . DIRECTORY_SEPARATOR . $entry;
                $extension = pathinfo($filename)['extension'];
                if (strcmp($extension, 'yml') === 0 || strcmp($extension, "yaml") === 0) {
                    $this->dataSources[substr($entry, 0, -(strlen($extension) + 1))] = \yaml_parse_file($filename);
                } else {
                    throw new WrongFileFormatException("data sources config file must be yaml file");
                }
            }
        }
        $this->dataSourcesManager->load($this->dataSources);
        $this->connectionManager->addConnectionFromDataSourceArray($this->dataSourcesManager->getDataSources());

        echo "<pre>";
        print_r($this->connectionManager->getConnections());
        echo "<h1>Error</h1>";
        print_r($this->connectionManager->getAndFlushErrors());
        echo "</pre>";
    }

    public function load(LoadListener $listener): void
    {
        try {
            $this->dataSourcesManager->load();
            $this->connectionManager->load();
            $this->entityManager->load();
        } catch (Exception\UnknownDataSourcesTypeException | EntityFormatException $e) {
            $listener->onException($e);
        }
        $listener->onComplete();
    }
    /**
     * Start PPHI
     */
    public function start(): void
    {
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return DataSourceManager
     */
    public function getDataSourcesManager(): DataSourceManager
    {
        return $this->dataSourcesManager;
    }
}

