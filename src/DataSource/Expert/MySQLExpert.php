<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 17:40
 */

namespace PPHI\DataSource\Expert;

use PPHI\DataSource\Source\DataSource;
use PPHI\DataSource\Source\MySQLDataSource;

class MySQLExpert extends Expert
{

    public function execute(string $str): ?DataSource
    {
        if (strcmp($str, "mysql") === 0) {
            return new MySQLDataSource($str);
        } else {
            return !is_null($this->getNext()) ? $this->getNext()->execute($str) : null;
        }
    }
}
