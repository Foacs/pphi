<?php

namespace PPHI;

use PPHI\Connector\ConnectionManager;
use PPHI\DataSource\DataSourceManager;
use PPHI\Entity\EntityManager;
use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\WrongFileFormatException;

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
    const VERSION = "0.1.0";

    const DATA_SOURCES_PATH = "pphi/datasources";
    const ENTITY_DIRECTORY_PATH = "entities";
    const ENTITY_NAMESPACE = "PPHI\\FunctionalTest\\entities\\";

    /**
     * @var DataSourceManager
     */
    private $dataSourcesManager;

    /**
     * @var ConnectionManager
     */
    private $connectionManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * PPHI constructor.
     * Create manager
     *
     * @throws DirectoryNotFoundException
     * @throws Exception\datasource\DataSourceDirectoryNotFoundException
     */
    public function __construct()
    {
        $this->dataSourcesManager = new DataSourceManager(self::DATA_SOURCES_PATH);
        $this->connectionManager = new ConnectionManager();
        $this->entityManager = new EntityManager(self::ENTITY_DIRECTORY_PATH, self::ENTITY_NAMESPACE);
    }

    /**
     * Initialise manager
     * Load file for manager
     *
     * @throws WrongFileFormatException when try to load a file in wrong format
     */
    public function preInit(): void
    {
        $this->dataSourcesManager->init();
        $this->entityManager->init();
    }

    /**
     * Load data into manager
     *
     * @throws Exception\UnknownDataSourcesTypeException when try to load data source with unknown type
     */
    public function init(): void
    {
        $this->dataSourcesManager->load();
        $this->connectionManager->addConnectionFromDataSourceArray($this->dataSourcesManager->getDataSources());
    }

    /**
     * Start PPHI
     */
    public function start(): void
    {
        $this->entityManager->load();
        echo "<pre>";
        print_r($this->entityManager->getLoadedElements());
        print_r($this->connectionManager->getConnections());
        echo "<h1>Error</h1>";
        print_r($this->connectionManager->getAndFlushErrors());
        echo "</pre>";
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}
