<?php

namespace PPHI\DataSource\Source;

use PPHI\Exception\WrongMySQLDataSourcesConfigurationException;

class MySQLDataSource implements DataSource
{

    private $dataSourceName;

    /**
     * MySQL database url
     * @var string
     */
    private $url;
    /**
     * MySQL database access port
     * @var integer
     */
    private $port;
    /**
     * MySQL database username
     * @var string
     */
    private $username;
    /**
     * MySQL database password
     * @var string
     */
    private $password;

    /**
     * MySQL database name
     *
     * @var string
     */
    private $database;

    /**
     * MySQLDataSource constructor.
     * @param string $dataSourceName
     */
    public function __construct(string $dataSourceName)
    {
        $this->dataSourceName = $dataSourceName;
    }

    /**
     * Setup the mysql data source
     *
     * @param array $config YAML configuration
     * @throws WrongMySQLDataSourcesConfigurationException when the data source configuration is wrong
     */
    public function setUp(array $config): void
    {
        if (isset($config['mysql'])) {
            $mysqlConfig = $config['mysql'];
            if (is_array($mysqlConfig) && !empty($mysqlConfig)) {
                $this->setUpField($mysqlConfig, "url");
                $this->setUpField($mysqlConfig, "port");
                $this->setUpField($mysqlConfig, "username");
                $this->setUpField($mysqlConfig, "password");
                $this->setUpField($mysqlConfig, "database");
            } else {
                throw new WrongMySQLDataSourcesConfigurationException("The field mysql must be an non-empty 
                array in " . $this->dataSourceName . " data source config");
            }
        } else {
            throw new WrongMySQLDataSourcesConfigurationException("The field mysql is required for MySQL data
             source " . $this->dataSourceName . " data source config");
        }
    }

    /**
     * Setup the given field
     *
     * @param array $config YAML config
     * @param string $fieldName the field name
     * @param bool $optional Throw an error is not optional field not found
     * @param null $default Default value for optional field
     * @throws WrongMySQLDataSourcesConfigurationException when the field is missing or wrong type
     */
    private function setUpField(array $config, string $fieldName, bool $optional = false, $default = null): void
    {
        if (isset($config[$fieldName])) {
            $this->$fieldName = $config[$fieldName];
        } else {
            if (!$optional) {
                throw new WrongMySQLDataSourcesConfigurationException("Missing mysql." . $fieldName .
                    ". Required for MySQL data source");
            } else {
                $this->$fieldName = $default;
            }
        }
    }
}
