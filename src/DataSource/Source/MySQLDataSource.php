<?php

namespace PPHI\DataSource\Source;

use PPHI\Connector\Database\MySQLConnector;
use PPHI\Exception\WrongMySQLDataSourcesConfigurationException;

/**
 * Class MySQLDataSource
 * @package PPHI\DataSource\Source
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.1.0-alpha First time this was introduced
 */
class MySQLDataSource extends DataSource
{

    /**
     * @var string
     */
    private $dataSourceName;

    /**
     * MySQL Database url
     * @var string
     */
    private $url;
    /**
     * MySQL Database access port
     * @var integer
     */
    private $port;
    /**
     * MySQL Database username
     * @var string
     */
    private $username;
    /**
     * MySQL Database password
     * @var string
     */
    private $password;

    /**
     * MySQL Database name
     * @var string
     */
    private $database;

    /**
     * MySQLDataSource constructor.
     * @param string $dataSourceName
     */
    public function __construct(string $dataSourceName)
    {
        parent::__construct();
        $this->dataSourceName = $dataSourceName;
    }

    /**
     * Setup the mysql data source
     *
     * @param array $config YAML configuration
     *
     * @throws WrongMySQLDataSourcesConfigurationException when the data source configuration is wrong
     *
     * @since 0.1.0-a First time it was introduced
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
     *
     * @throws WrongMySQLDataSourcesConfigurationException when the field is missing or wrong type
     *
     * @since 0.1.0-a First time it was introduced
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

    /**
     * @return string
     *
     * @since 0.1.0-a First time it was introduced
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     *
     * @since 0.1.0-a First time it was introduced
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     *
     * @since 0.1.0-a First time it was introduced
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     *
     * @since 0.1.0-a First time it was introduced
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     *
     * @since 0.1.0-a First time it was introduced
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return "mysql";
    }

    public function setUpConnector(): void
    {
        $connector = new MySQLConnector();
        if ($connector->connect($this)) {
            $this->setConnector($connector);
        } else {
            $this->setConnector(null);
        }
    }
}
