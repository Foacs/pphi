<?php

namespace PPHI\FunctionalTest;

use PPHI\FunctionalTest\entities\Brand;
use PPHI\FunctionalTest\entities\Car;
use PPHI\PPHI;

class Runner
{
    /**
     * @var PPHI
     */
    private $pphi;

    /**
     * @var Car
     */
    private $car;

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
        $this->pphi->preInit();
        $this->pphi->init();
        $this->pphi->start();

        $this->car = new Car();
        $this->car->setBrand(new Brand());
        $this->car->getBrand()->setName("renault");
        $this->car->setColor("rouge");

        $this->pphi->getEntityManager()->save($this->car);

        echo "<pre>";
        var_dump($this->car);
        echo "</pre>";
    }
}
