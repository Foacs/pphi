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
use PPHI\Connector\Query\Builder\SaveQueryBuilder;
use PPHI\Connector\Query\Builder\SelectionQueryBuilder;
use PPHI\Connector\Query\MySQLQuery;
use PPHI\Connector\Query\Query;
use PPHI\Entity\EntityField;

class MySQLQueryBuilder implements QueryBuilder, SelectionQueryBuilder, CreationQueryBuilder, SaveQueryBuilder
{
    /**
     * @var string
     */
    private $sqlQuery;

    private $fields = [];
    private $primaryKey = [];
    private $values = [];
    private $tableName;
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(string $arg): SelectionQueryBuilder
    {
        $this->sqlQuery .= "select " . $arg;
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
        //$this->sqlQuery .= "CREATE TABLE ".$directoryName."(";
        $this->tableName = $directoryName;
        return $this;
    }

    public function withField(string $fieldName, string $fieldType, bool $pk = false): CreationQueryBuilder
    {
        $this->fields[$fieldName] = $fieldType;
        if ($pk) {
            $this->primaryKey[] = $fieldName;
        }
        //$this->sqlQuery .= $fieldName . " " . $fieldType . ", ";
        return $this;
    }

    public function withFields(array $fields): CreationQueryBuilder
    {
        foreach ($fields as $field) {
            if ($field instanceof EntityField) {
                $this->withField($field->getName(), $field->getType(), $field->isPrimaryKey());
            }
        }
        return $this;
    }

    public function save(string $tableName): SaveQueryBuilder
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function buildCreate(): Query
    {
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->tableName . "(";

        foreach ($this->fields as $fieldName => $fieldType) {
            $sql .= $fieldName . " " . $this->convertFieldType($fieldType) . ", ";
        }
        if (!empty($this->primaryKey)) {
            $sql .= "PRIMARY KEY (";
            foreach ($this->primaryKey as $pk) {
                $sql .= $pk . ", ";
            }
            $sql = rtrim($sql, ", ") . ")";
        }
        $sql = rtrim($sql, ", ") . ")";
        return new MySQLQuery($this->pdo, $sql);
    }

    public function buildSave(): Query
    {
        $sql = "INSERT INTO " . $this->tableName . " (";
        foreach ($this->fields as $fieldName => $fieldType) {
            $sql .= $fieldName . ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= ") VALUES(";
        foreach ($this->values as $value) {
            $sql .= "'" . $value . "'" . ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= ") ON DUPLICATE KEY UPDATE ";
        foreach ($this->fields as $fieldName => $fieldType) {
            $sql .= $fieldName . " = " . "'" . $this->values[$fieldName] . "'" . ", ";
        }
        $sql = rtrim($sql, ", ");
        return new MySQLQuery($this->pdo, $sql);
    }

    public function buildSelect(): Query
    {
        // TODO: Implement buildSelect() method.
        return new MySQLQuery($this->pdo, "");
    }

    public function withValue(EntityField $field, $value): SaveQueryBuilder
    {
        $this->fields[$field->getName()] = $field->getType();
        $this->values[$field->getName()] = $value;
        return $this;
    }
}
