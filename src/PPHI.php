<?php

namespace PPHI;

use PPHI\Connector\ConnectionManager;
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
     * @var ConnectionManager
     */
    private $connectionManager;

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

    /**
     * Load data into manager
     *
     * @param InitListener $listener
     */
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
