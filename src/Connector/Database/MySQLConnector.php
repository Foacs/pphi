<?php
/**
 * Copyright Foacs
 * contributor(s): Alexis DINQUER
 *
 * (2019-05-13)
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
 *
 * This software includes
 */

namespace PPHI\Connector\Database;

use PDO;
use PPHI\Connector\Connector;
use PPHI\Connector\ConnectorError;
use PPHI\DataSource\Source\DataSource;
use PPHI\DataSource\Source\MySQLDataSource;

/**
 * Class MySQLConnector
 * Use to hold a connection to a MySQL server
 *
 * @package PPHI\Connector\Database
 *
 * @package PPHI
 * @version 0.1.0
 * @api
 * @license CeCILL-C
 * @author Foacs
 */
class MySQLConnector implements Connector
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var ConnectorError
     */
    private $error;

    /**
     * Connect to the data source with the specified PDO or new one if null.
     *
     * @param DataSource $dataSource The data source
     * @param PDO|null $pdo The PDO used to connect
     *
     * @return bool True if connect successfully
     */
    public function connect(DataSource $dataSource, PDO $pdo = null): bool
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
            $this->pdo = $pdo ?? new PDO(
                $dns,
                $dataSource->getUsername(),
                $dataSource->getPassword(),
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
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
     *
     * @return bool True if connected
     */
    public function isConnected(): bool
    {
        // TODO check connection
        return false;
    }

    /**
     * Close the connection with data source
     *
     * @return bool True if successfully closed
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * Get the errors generated during connection
     *
     * @return ConnectorError|null The generated errors
     */
    public function getError(): ?ConnectorError
    {
        return $this->error;
    }
}
