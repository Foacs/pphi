<?php

namespace PPHI\DataSource;

use PPHI\DataSource\Expert\MySQLExpert;
use PPHI\DataSource\Expert\Processor;
use PPHI\DataSource\Source\DataSource;
use PPHI\Exception\UnknownDataSourcesTypeException;

class DataSourceManager
{
    /**
     * @var Processor
     */
    private $processor;

    /**
     * @var array
     */
    private $dataSources = [];

    /**
     * DataSourceManager constructor.
     */
    public function __construct()
    {
        $this->processor = new Processor();
        $this->processor->pushExpert(new MySQLExpert());
    }

    /**
     * Load all data sources from config directory in $dataSources;
     *
     * @param array $dataSources Contains all data sources configuration
     * @throws UnknownDataSourcesTypeException when found an unknown data sources type
     */
    public function load(array $dataSources): void
    {
        foreach ($dataSources as $dataSourceName => $dataSource) {
            $dataSourceType = strtolower($dataSource['type']) ?? "mysql";
            $ds = $this->processor->execute($dataSourceType);
            if (!is_null($ds)) {
                $ds->setUp($dataSource);
                $this->dataSources[$dataSourceName] = $ds;
            } else {
                throw new UnknownDataSourcesTypeException("The data sources type " . $dataSourceType . " is unknown");
            }
        }
    }

    /**
     * Get all loaded data sources
     * @return DataSource[] An array of DataSource
     */
    public function getDataSources(): array
    {
        return $this->dataSources;
    }
}
