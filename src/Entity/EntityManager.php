<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 18:41
 */

namespace PPHI\Entity;

use PPHI\Connector\ConnectionManager;
use PPHI\Connector\Connector;
use PPHI\DataSource\DataSourceManager;
use PPHI\Exception\DirectoryNotFoundException;
use PPHI\Exception\entity\EntityClassException;
use PPHI\Exception\entity\EntityFormatException;
use PPHI\Utils\DirectoryLoader;

/**
 * Class EntityManager
 *
 * @package PPHI\Entity
 *
 * @license GPL 3.0 or later
 * @author Alexis DINQUER <adinquer@yahoo.com>
 * @since 0.2.0-alpha First time this was introduced
 */
class EntityManager extends DirectoryLoader
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var array
     */
    private $entities = [];

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

    public function save($entity): bool
    {
        if ($entity) {
            return false;
        }
        return false;
    }

    /**
     * Foreach loaded ReflectionClass apply checks
     *
     * @param DataSourceManager $dataSourceManager
     *
     * @throws EntityFormatException when |
     *  entity not instantiable |
     *  entity has no property |
     *  entity property has no doc
     */
    public function load()
    {

        foreach ($this->getLoadedElements() as $entity) {
            if ($entity instanceof \ReflectionClass) {
                if (!$entity->isInstantiable()) {
                    throw new EntityFormatException("The entity " . $entity->getName()
                        . " have to be instantiable");
                }
                $properties = $entity->getProperties();
                if (empty($properties)) {
                    throw new EntityFormatException("The entity " . $entity->getName()
                        . " has no property");
                }
                $this->entities[$entity->getShortName()] = [];
                foreach ($properties as $property) {
                    $docComment = $property->getDocComment();
                    if (false === $docComment) {
                        throw new EntityFormatException("The property " . $property->getName() . " in "
                            . $entity->getName() . " has no PhpDoc");
                    }
                    if (preg_match("#\@var *([a-zA-Z][a-zA-Z0-9]*)#", $docComment, $type) === 0) {
                        throw new EntityFormatException("The property documentation for "
                            . $property->getName() . " in " . $entity->getName() . " must have a @var [type] element");
                    }
                    $this->entities[$entity->getShortName()][$property->getName()] = $type[1];
                }
            }
        }
        echo "<pre>";
        var_dump($this->entities);
        /*echo $entity->getName();
        echo " has property ";
        echo($property->getName());
        echo " typed ";
        echo($type[1]);*/
        echo "</pre>";
    }

    public function start(ConnectionManager $connectionManager)
    {
        foreach ($connectionManager->getConnections() as $connection) {
            if ($connection instanceof Connector) {
                foreach ($this->entities as $entityName => $entity) {
                    $qb = $connection->getQueryBuilder()
                        ->createDirectory($entityName);
                    foreach ($entity as $fieldName => $field) {
                        $qb->withField($fieldName, $field);
                    }
                    $qb->build()->execute();
                }
            }
        }
    }
}
