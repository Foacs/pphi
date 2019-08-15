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

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    public function getType(): string
    {
        return "mysql";
    }
}
