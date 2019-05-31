<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 15:11
 */

namespace PPHI\Connector\Query\Builder;

use PPHI\Connector\Query\Query;
use PPHI\Entity\EntityField;

interface SaveQueryBuilder
{
    public function buildSave(): Query;

    public function withValue(EntityField $field, $value): SaveQueryBuilder;
}
