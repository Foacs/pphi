<?php

namespace PPHI\FunctionalTest;

use PPHI\FunctionalTest\dao\BrandDao;
use PPHI\FunctionalTest\entities\Brand;
use PPHI\FunctionalTest\entities\Car;
use PPHI\FunctionalTest\listener\InitListener;
use PPHI\FunctionalTest\listener\LoadListener;
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
     * @throws \PPHI\Exception\entity\EntityClassException
     */
    public function __construct()
    {

        $this->pphi = PPHI::getInstance();
        $this->pphi->init(new InitListener());
        $this->pphi->load(new LoadListener());

        $this->car = new Car();
        $this->car->setBrand(new Brand());
        $this->car->getBrand()->setName("Renault");
        $this->car->getBrand()->setId("5cf136d2000a7");
        $this->car->setColor("rouge");

        $dao = new BrandDao();
        $dao->save($this->car->getBrand());

        //$this->pphi->getEntityManager()->save($this->car);
    }
}
