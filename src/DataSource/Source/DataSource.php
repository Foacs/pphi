<?php

namespace PPHI\DataSource\Source;

abstract class DataSource
{
    /**
     * @var string
     */
    private $id;

    protected function __construct()
    {
        $this->id = uniqid("ds_");
    }

    /**
     * Setup the data source
     *
     * @param array $str YAML Configuration
     */
    abstract public function setUp(array $str): void;

    /**
     * Get the data source type
     *
     * @return string Data source type
     */
    abstract public function getType(): string;

    /**
     * Gets the dataSource identifier
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
