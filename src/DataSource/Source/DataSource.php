<?php

namespace PPHI\DataSource\Source;

use PPHI\Connector\Connector;

abstract class DataSource
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Connector
     */
    private $connector = null;

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

    abstract public function setUpConnector(): void;

    /**
     * Gets the dataSource identifier
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Connector
     */
    public function getConnector(): Connector
    {
        if ($this->connector === null || !$this->connector->isConnected()) {
            $this->setUpConnector();
        }
        return $this->connector;
    }

    /**
     * @param Connector $connector
     */
    protected function setConnector(Connector $connector): void
    {
        $this->connector = $connector;
    }
}
