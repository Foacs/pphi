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
 */

namespace PPHI\Connector;

use PPHI\Connector\Database\MySQLConnector;
use PPHI\DataSource\Source\DataSource;
use PPHI\Exception\UnknownDataSourcesTypeException;

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
     * Add connection for a data source
     *
     * @param DataSource $dataSource data source which will be add
     * @return bool True if successfully added
     */
    public function addConnectionFromDataSource(DataSource $dataSource, Connector $givenConnector = null): bool
    {
        if (array_key_exists($dataSource->getId(), $this->connections)) {
            return false;
        }
        try {
            $connector = $givenConnector ?? $this->buildConnectorFromDataSource($dataSource);
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
}
