<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 15:26
 */

namespace PPHI\Entity;

trait Entity
{
    /**
     * @var string
     * @primaryKey
     */
    public $id;

    /**
     * @return mixed
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
