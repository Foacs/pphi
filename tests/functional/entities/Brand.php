<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 18/05/19
 * Time: 13:22
 */

namespace PPHI\FunctionalTest\entities;

class Brand
{

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}