<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 18:41
 */

namespace PPHI\DataSource;

use PPHI\DataSource\Expert\MySQLExpert;
use PPHI\DataSource\Expert\Processor;
use PPHI\Exception\datasource\DataSourceDirectoryNotFoundException;
use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\UnknownDataSourcesTypeException;
use PPHI\Utils\DirectoryLoader;

/**
 * Class DataSourceManager
 * @package PPHI\DataSource
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.1.0-alpha First time this was introduced
 * @since 0.2.0-alpha Extends DirectoryLoader
 */
class DataSourceManager extends DirectoryLoader
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
     *
     * @param string $path The path of data source directory
     *
     * @throws DataSourceDirectoryNotFoundException When the data source directory doesn't exists
     */
    public function __construct(string $path)
    {
        try {
            parent::__construct($path);
        } catch (DirectoryNotFoundException $e) {
            throw new DataSourceDirectoryNotFoundException("Data source directory not found", $e->getCode(), $e);
        }
        $this->processor = new Processor();
        $this->processor->pushExpert(new MySQLExpert());
    }

    /**
     * Load all data sources from config directory in $dataSources;
     *
     * @param array $dataSources Contains all data sources configuration
     *
     * @throws UnknownDataSourcesTypeException when found an unknown data sources type
     */
    public function load(): void
    {
        foreach ($this->getLoadedElements() as $dataSourceName => $dataSource) {
            if (!($dataSource['ignored'] ?? false)) {
                $dataSourceType = strtolower($dataSource['type']) ?? "mysql";
                $ds = $this->processor->execute($dataSourceType);
                if (!is_null($ds)) {
                    $ds->setUp($dataSource);
                    $this->dataSources[$dataSourceName] = $ds;
                } else {
                    throw new UnknownDataSourcesTypeException("The data sources type " . $dataSourceType .
                        " is unknown");
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getValidExtension(): array
    {
        return ["yml", "yaml"];
    }

    /**
     * @inheritdoc
     */
    public function parse(string $fileName)
    {
        return \yaml_parse_file($fileName);
    }

    /**
     * @return array
     */
    public function getDataSources(): array
    {
        return $this->dataSources;
    }
}
