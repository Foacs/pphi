<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 15:38
 */

namespace PPHI\Entity;

class EntityField
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $primaryKey;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function __construct(string $name, string $type, bool $primaryKey = false)
    {
        $this->setName($name);
        $this->setType($type);
        $this->setPrimaryKey($primaryKey);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isPrimaryKey(): bool
    {
        return $this->primaryKey;
    }

    /**
     * @param bool $primaryKey
     */
    public function setPrimaryKey(bool $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }
}
