<?php

namespace PPHI\FunctionalTest;

use PPHI\PPHI;

class Runner
{
    private $pphi;

    /**
     * Runner constructor.
     * @throws \PPHI\Exception\DirectoryNotFoundException
     * @throws \PPHI\Exception\UnknownDataSourcesTypeException
     * @throws \PPHI\Exception\WrongFileFormatException
     * @throws \PPHI\Exception\datasource\DataSourceDirectoryNotFoundException
     */
    public function __construct()
    {

        $this->pphi = new PPHI();
    }
}
