<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 21/05/19
 * Time: 18:35
 */

namespace PPHI\Connector\Query;

class MySQLQuery implements Query
{
    /**
     * @var string
     */
    private $sqlQuery;
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo, string $sqlQuery)
    {
        $this->sqlQuery = $sqlQuery;
        $this->pdo = $pdo;
    }

    public function execute()
    {
        $this->pdo->query($this->sqlQuery)->execute();
    }
}
