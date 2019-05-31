<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 21/05/19
 * Time: 19:51
 */

namespace PPHI\Connector\Query\Builder;

use PPHI\Connector\Query\Query;

interface SelectionQueryBuilder
{
    public function from(string $arg): QueryBuilder;

    public function where(string $arg): QueryBuilder;

    public function buildSelect(): Query;
}
