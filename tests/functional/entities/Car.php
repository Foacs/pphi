<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 18:39
 */

namespace PPHI\FunctionalTest\entities;

/**
 * Class Car
 * @package PPHI\FonctionalTest\entities
 */
class Car
{


    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $color;

    /**
     * @return mixed
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}
