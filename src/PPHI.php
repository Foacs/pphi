<?php

namespace PPHI;

use PPHI\Connector\ConnectionManager;
use PPHI\DataSource\DataSourceManager;
use PPHI\Entity\EntityManager;
use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\WrongFileFormatException;

class PPHI
{
    const VERSION = "0.1.0";

    const DATA_SOURCES_PATH = "pphi/datasources";
    const ENTITY_DIRECTORY_PATH = "entities";

    /**
     * @var array
     */
    private $dataSources = array();

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
     * Load all dataSources found in pphi/datasources directory
     *
     * @throws Exception\UnknownDataSourcesTypeException when a data sources type is unknown
     * @throws Exception\datasource\DataSourceDirectoryNotFoundException
     * @throws WrongFileFormatException when dataSources directory contains not YAML files
     * @throws DirectoryNotFoundException
     */
    public function __construct()
    {
        $this->dataSourcesManager = new DataSourceManager(self::DATA_SOURCES_PATH);
        $this->connectionManager = new ConnectionManager();
        $this->entityManager = new EntityManager(self::ENTITY_DIRECTORY_PATH);

        $this->dataSourcesManager->init();
        $this->entityManager->init();

        $this->dataSourcesManager->load($this->dataSources);
        //$this->connectionManager->addConnectionFromDataSourceArray($this->dataSourcesManager->getLoadedElements());

        echo "<pre>";
        print_r($this->dataSourcesManager->getLoadedElements());
        print_r($this->connectionManager->getConnections());
        echo "<h1>Error</h1>";
        print_r($this->connectionManager->getAndFlushErrors());
        echo "</pre>";
    }
}
