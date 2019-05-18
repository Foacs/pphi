<?php

namespace PPHI\FonctionalTest;

use PPHI\PPHI;

class Runner
{
    private $pphi;

    /**
     * Runner constructor.
     * @throws \PPHI\Exception\ConfigNotFoundException
     * @throws \PPHI\Exception\UnknownDataSourcesTypeException
     * @throws \PPHI\Exception\WrongFileFormatException
     */
    public function __construct()
    {

        $this->pphi = new PPHI();
    }
}
