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
 *
 * @package PPHI\Entity
 * @author Alexis DINQUER <adinquer@yahoo.com>
 */
class EntityManager extends DirectoryLoader
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * EntityManager constructor.
     *
     * @param string $path Entity directory path
     * @param string $namespace
     *
     * @throws DirectoryNotFoundException
     */
    public function __construct(string $path, string $namespace)
    {
        parent::__construct($path);
        $this->namespace = $namespace;
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
        /** @noinspection PhpIncludeInspection */
        include_once $fileName;
        $className = pathinfo($fileName, PATHINFO_FILENAME);

        try {
            return new \ReflectionClass($this->namespace . $className);
        } catch (\ReflectionException $e) {
            throw new EntityClassException(
                "The entity in file " . $fileName . " is not in good format",
                $e->getCode(),
                $e
            );
        }
    }
}
