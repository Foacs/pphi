<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 13/05/19
 * Time: 19:49
 */

namespace PPHI\Connector\Database;

use PPHI\Connector\Connector;
use PPHI\Connector\ConnectorError;
use PPHI\DataSource\Source\DataSource;
use PPHI\DataSource\Source\MySQLDataSource;

class MySQLConnector implements Connector
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var ConnectorError
     */
    private $error;

    /**
     * Connect to the data source
     * @param DataSource $dataSource The data source
     * @return bool True if connect successfully
     */
    public function connect(DataSource $dataSource): bool
    {
        if (!$dataSource instanceof MySQLDataSource) {
            $this->error = new ConnectorError(get_class($this), "The data source is not a MySQLDataSource", 1);
            return false;
        }
        $dns = 'mysql:host=' . $dataSource->getUrl()
            . ';port=' . $dataSource->getPort() . ';dbname=' . $dataSource->getDatabase();
        var_dump($dns);
        var_dump($dataSource->getPassword());
        try {
            $this->pdo = new \PDO(
                $dns,
                $dataSource->getUsername(),
                $dataSource->getPassword(),
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
            );
        } catch (\PDOException $e) {
            $this->error = new ConnectorError(
                get_class($this),
                "Error when connecting to MySQL database",
                2,
                $e
            );
            return false;
        }
        return true;
    }

    /**
     * Check if is connected to the data source
     * @return bool True if connected
     */
    public function isConnected(): bool
    {
        // TODO check connection
        return false;
    }

    /**
     * Close the connection with data source
     * @return bool True if successfully closed
     */
    public function close(): bool
    {
        return true;
    }

    public function getError(): ?ConnectorError
    {
        return $this->error;
    }
}
