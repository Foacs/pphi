<?php

namespace PPHI;

use PPHI\Connector\ConnectionManager;
use PPHI\DataSource\DataSourceManager;
use PPHI\Exception\ConfigNotFoundException;
use PPHI\Exception\WrongFileFormatException;

class PPHI
{
    const VERSION = "1.0-a1";

    const DATA_SOURCES_PATH = "pphi/datasources";

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
     * PPHI constructor.
     * Load all dataSources found in pphi/datasources directory
     *
     * @throws ConfigNotFoundException when directory pphi/datasources is not found
     * @throws WrongFileFormatException when dataSources directory contains not YAML files
     * @throws Exception\UnknownDataSourcesTypeException when a data sources type is unknown
     */
    public function __construct()
    {
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
}
