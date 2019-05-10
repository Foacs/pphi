<?php

namespace PPHI\DataSource\Source;

interface DataSource
{
    /**
     * Setup the data source
     *
     * @param array $str YAML Configuration
     */
    public function setUp(array $str): void;
}
