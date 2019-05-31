<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 21/05/19
 * Time: 18:35
 */

namespace PPHI\Connector\Query\Builder\MySQL;

use PPHI\Connector\Query\Builder\CreationQueryBuilder;
use PPHI\Connector\Query\Builder\QueryBuilder;
use PPHI\Connector\Query\Builder\SelectionQueryBuilder;
use PPHI\Connector\Query\MySQLQuery;
use PPHI\Connector\Query\Query;

class MySQLQueryBuilder implements QueryBuilder, SelectionQueryBuilder, CreationQueryBuilder
{
    /**
     * @var string
     */
    private $sqlQuery;

    private $createDirectory = false;
    private $fields = [];
    private $tableName;
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(string $arg): SelectionQueryBuilder
    {
        if (!$this->createDirectory) {
            $this->sqlQuery .= "select " . $arg;
        }
        return $this;
    }

    public function from(string $arg): QueryBuilder
    {
        $this->sqlQuery .= " from " . $arg;
        return $this;
    }

    public function where(string $arg): QueryBuilder
    {
        $this->sqlQuery .= " where " . $arg;
        return $this;
    }

    public function build(): Query
    {
        $sql = "";
        if ($this->createDirectory) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(";
        }
        foreach ($this->fields as $fieldName => $fieldType) {
            $sql .= $fieldName . " " . $this->convertFieldType($fieldType) . ", ";
        }
        $sql = rtrim($sql, ", ") . ")";
        return new MySQLQuery($this->pdo, $sql);
    }

    private function convertFieldType(string $fieldType): string
    {
        switch ($fieldType) {
            case "string":
                return "varchar(255)";
            case "int":
                return "int";
            default:
                return ""; //TODO default return
        }
    }

    public function createDirectory(string $directoryName): CreationQueryBuilder
    {
        if (!$this->createDirectory) {
            //$this->sqlQuery .= "CREATE TABLE ".$directoryName."(";
            $this->tableName = $directoryName;
            $this->createDirectory = true;
        }
        return $this;
    }

    public function withField(string $fieldName, string $fieldType): QueryBuilder
    {
        if ($this->createDirectory) {
            $this->fields[$fieldName] = $fieldType;
            //$this->sqlQuery .= $fieldName . " " . $fieldType . ", ";
        }
        return $this;
    }
}
