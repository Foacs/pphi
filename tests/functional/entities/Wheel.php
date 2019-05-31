<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 18/05/19
 * Time: 14:14
 */

namespace PPHI\FunctionalTest\entities;

use PPHI\Entity\Entity;

class Wheel
{
    use Entity;
    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $color;

    /**
     * ezjdbejf
     * @var int
     * efmz
     */
    private $size;

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}
