<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 13/05/19
 * Time: 20:21
 */

namespace PPHI\Connector;

use PPHI\Connector\Database\MySQLConnector;
use PPHI\DataSource\DataSourceManager;
use PPHI\DataSource\Source\DataSource;
use PPHI\Exception\UnknownDataSourcesTypeException;

/**
 * Class ConnectionManager
 * Used to handle connection with data source
 *
 * @package PPHI\Connector
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.1.0-alpha First time this was introduced
 */
class ConnectionManager
{


    /**
     * @var array
     */
    private $connections = array();

    /**
     * @var array
     */
    private $errors = array();

    /**
     * @var DataSourceManager
     */
    private $dataSourceManager;

    /**
     * Add connection for a data source
     *
     * @param DataSource $dataSource data source which will be add
     * @return bool True if successfully added
     */
    public function addConnectionFromDataSource(DataSource $dataSource): bool
    {
        if (array_key_exists($dataSource->getId(), $this->connections)) {
            return false;
        }
        try {
            $connector = $this->buildConnectorFromDataSource($dataSource);
            if (!$connector->connect($dataSource)) {
                array_push($this->errors, $connector->getError());
                return false;
            }
            array_push($this->connections, $connector);
        } catch (UnknownDataSourcesTypeException $e) {
            return false;
        }
        return true;
    }

    /**
     * Add connection for each data sources in the given array
     *
     * @param array $dataSources Array of DataSources
     * @return int Number of success
     */
    public function addConnectionFromDataSourceArray(array $dataSources): int
    {
        $res = 0;
        foreach ($dataSources as $dataSource) {
            if ($this->addConnectionFromDataSource($dataSource)) {
                $res++;
            }
        }
        return $res;
    }

    /**
     * @param DataSource $dataSource
     * @return Connector
     * @throws UnknownDataSourcesTypeException when data source type is unknown
     */
    private function buildConnectorFromDataSource(DataSource $dataSource): Connector
    {
        switch ($dataSource->getType()) {
            case 'mysql':
                return new MySQLConnector();
            default:
                throw new UnknownDataSourcesTypeException("The data source type "
                    . $dataSource->getType() . " is unknown");
        }
    }

    /**
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }

    /**
     * @return array
     */
    public function getAndFlushErrors(): array
    {
        $tmp = $this->errors;
        $this->errors = [];
        return $tmp;
    }

    public function init(DataSourceManager $dataSourcesManager)
    {
        $this->dataSourceManager = $dataSourcesManager;
    }

    public function load()
    {
        $this->addConnectionFromDataSourceArray($this->dataSourceManager->getDataSources());
    }
}
