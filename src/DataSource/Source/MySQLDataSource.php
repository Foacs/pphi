<?php
/**
 * Copyright Foacs
 * contributor(s): Alexis DINQUER
 *
 * (2019-05-09)
 *
 * contact@foacs.me
 *
 * This software is a computer program whose purpose is to handle data persistence in PHP
 *
 * This software is governed by the CeCILL-C license under french law and
 * abiding by the rules of distribution of free software. You can use,
 * modify and/ or redistribute the software under the terms of the CeCILL-C
 * license as circulated by CEA, CNRS and INRIA at the follow URL
 * "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy,
 * modify and redistribute granted by the license, users are provided only
 * with a limited warranty and the software's authors, the holder of the
 * economic rights, and the successive licensors have only limited
 * liability.
 *
 * In this respect, the user's attention is drawn to the risk associated
 * with loading, using, modifying and/ or developing or reproducing the
 * software by the user in light of its specific status of free software,
 * that may mean that it is complicated to manipulate, and that also
 * therefore means that it is reserved for developers and experienced
 * professionals having in-depth computer knowledge. Users are therefore
 * encouraged to load and test the software's suitability as regards their
 * requirements in conditions enabling the security of their systems and/or
 * data to be ensure and, more generally, to use and operate it in the
 * same conditions as regards security.
 *
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL-C license and that you accept its terms.
 */

namespace PPHI\DataSource\Source;

use PPHI\Exception\WrongMySQLDataSourcesConfigurationException;

/**
 * Class MySQLDataSource
 * Represent a MySQL data source.
 *
 * @package PPHI\DataSource\Source
 * @version 0.1.0
 * @api
 * @license CeCILL-C
 * @author Foacs
 */
class MySQLDataSource extends DataSource
{

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
        parent::__construct();
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
        if (!isset($config['mysql'])) {
            throw new WrongMySQLDataSourcesConfigurationException("The field mysql is required for MySQL data
             source " . $this->dataSourceName . " data source config");
        }
        $mysqlConfig = $config['mysql'];
        if (!is_array($mysqlConfig) || empty($mysqlConfig)) {
            throw new WrongMySQLDataSourcesConfigurationException("The field mysql must be an non-empty 
            array in " . $this->dataSourceName . " data source config");
        }
        $this->setUpField($mysqlConfig, "url");
        $this->setUpField($mysqlConfig, "port");
        $this->setUpField($mysqlConfig, "username");
        $this->setUpField($mysqlConfig, "password");
        $this->setUpField($mysqlConfig, "database");
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
     */
    private function setUpField(array $config, string $fieldName, bool $optional = false, $default = null): void
    {
        if (isset($config[$fieldName])) {
            $this->$fieldName = $config[$fieldName];
        } else {
            if (!$optional) {
                throw new WrongMySQLDataSourcesConfigurationException("Missing mysql." . $fieldName .
                    ". Required for MySQL data source");
            }
            $this->$fieldName = $default;
        }
    }

    /**
     * Get the username used to connect to the MySQL server.
     *
     * @return string the username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get the password used to connect to the MySQL server.
     *
     * @return string The password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the database port.
     *
     * @return int The port
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Get the MySQL server's URL.
     *
     * @return string The URL
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the MySQL database name.
     *
     * @return string The database name.
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * Get the data source type (mysql)
     *
     * @return string The database type.
     */
    public function getType(): string
    {
        return "mysql";
    }
}
