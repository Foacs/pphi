<?php

namespace PPHI\FunctionalTest;

use PPHI\FunctionalTest\entities\Brand;
use PPHI\FunctionalTest\entities\Car;
use PPHI\FunctionalTest\listener\InitListener;
use PPHI\FunctionalTest\listener\PreInitListener;
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
     * @throws \PPHI\Exception\datasource\DataSourceDirectoryNotFoundException
     * @throws \PPHI\Exception\entity\EntityFormatException
     */
    public function __construct()
    {

        $this->pphi = new PPHI();
        $this->pphi->preInit(new PreInitListener());
        $this->pphi->init(new InitListener());
        $this->pphi->start();

        $this->car = new Car();
        $this->car->setBrand(new Brand());
        $this->car->getBrand()->setName("renault");
        $this->car->setColor("rouge");

        $this->pphi->getEntityManager()->save($this->car);
    }
}
