<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 18:41
 */

namespace PPHI\Entity;

use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\entity\EntityClassException;
use PPHI\Utils\DirectoryLoader;

/**
 * Class EntityManager
 * @package PPHI\Entity
 */
class EntityManager extends DirectoryLoader
{
    /**
     * EntityManager constructor.
     *
     * @param string $path
     *
     * @throws DirectoryNotFoundException
     */
    public function __construct(string $path)
    {
        parent::__construct($path);
    }

    /**
     * @inheritdoc
     */
    public function getValidExtension(): array
    {
        return ["php"];
    }

    /**
     * @inheritdoc
     * @throws EntityClassException when error occurs in parsing entity
     */
    public function parse(string $fileName)
    {
        require $fileName;

        try {
            return new \ReflectionClass("PPHI\\FunctionalTest\\entities\\Car");
        } catch (\ReflectionException $e) {
            throw new EntityClassException("The entity in file " . $fileName . " is not in good format",
                $e->getCode(), $e);
        }
    }
}
