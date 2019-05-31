<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 21/05/19
 * Time: 18:31
 */

namespace PPHI\Connector\Query\Builder;

interface QueryBuilder
{

    public function createDirectory(string $directoryName): CreationQueryBuilder;

    public function select(string $arg): SelectionQueryBuilder;

    public function save(string $tableName): SaveQueryBuilder;
}
