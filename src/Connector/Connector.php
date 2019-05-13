<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 13/05/19
 * Time: 19:49
 */

namespace PPHI\Connector;

use PPHI\DataSource\Source\DataSource;

interface Connector
{
    /**
     * Connect to the data source
     * @param DataSource $dataSource The data source
     * @return bool True if connect successfully
     */
    public function connect(DataSource $dataSource): bool;

    /**
     * Check if is connected to the data source
     * @return bool True if connected
     */
    public function isConnected(): bool;

    /**
     * Close the connection with data source
     * @return bool True if successfully closed
     */
    public function close(): bool;

    public function getError(): ?ConnectorError;
}
