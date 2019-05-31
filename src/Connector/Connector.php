<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 13/05/19
 * Time: 19:49
 */

namespace PPHI\Connector;

use PPHI\Connector\Query\Builder\QueryBuilder;
use PPHI\DataSource\Source\DataSource;

/**
 * Interface Connector
 * @package PPHI\Connector
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.1.0-alpha First time this was introduced
 */
interface Connector
{
    /**
     * Connect to the data source
     *
     * @param DataSource $dataSource The data source
     *
     * @return bool True if connect successfully
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function connect(DataSource $dataSource): bool;

    /**
     * Check if is connected to the data source
     * @return bool True if connected
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function isConnected(): bool;

    /**
     * Close the connection with data source
     * @return bool True if successfully closed
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function close(): bool;

    /**
     * Gets the error which has occurred
     * @return null|ConnectorError Error occurred
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function getError(): ?ConnectorError;

    public function getQueryBuilder(): QueryBuilder;
}
