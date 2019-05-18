<?php

namespace PPHI\DataSource\Source;

/**
 * Class DataSource
 * @package PPHI\DataSource\Source
 *
 * @since 0.1.0-a Handle ID & Type
 *
 * @author Alexis DINQUER <adinquer@yahoo.com>
 */
abstract class DataSource
{
    /**
     * @var string
     */
    private $id;

    /**
     * DataSource constructor.
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    protected function __construct()
    {
        $this->id = uniqid("ds_");
    }

    /**
     * Setup the data source
     *
     * @param array $str YAML Configuration
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    abstract public function setUp(array $str): void;

    /**
     * Get the data source type
     *
     * @return string Data source type
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    abstract public function getType(): string;

    /**
     * Gets the dataSource identifier
     *
     * @return string
     *
     * @since 0.1.0-a First time it was introduced
     * @api This method will not change until major release
     */
    public function getId(): string
    {
        return $this->id;
    }
}
