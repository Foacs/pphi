<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 21/05/19
 * Time: 19:52
 */

namespace PPHI\Connector\Query\Builder;

use PPHI\Connector\Query\Query;

interface CreationQueryBuilder
{
    public function withField(string $fieldName, string $fieldType, bool $pk = false): CreationQueryBuilder;

    public function withFields(array $fields): CreationQueryBuilder;

    public function buildCreate(): Query;
}
