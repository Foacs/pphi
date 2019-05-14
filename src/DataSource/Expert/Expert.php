<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 17:26
 */

namespace PPHI\DataSource\Expert;

use PPHI\DataSource\Source\DataSource;

abstract class Expert
{
    /**
     * @var Expert
     */
    private $next;

    abstract public function execute(string $str): ?DataSource;

    /**
     * @return Expert
     */
    public function getNext(): ?Expert
    {
        return $this->next;
    }

    /**
     * @param Expert $next next expert in the chain
     */
    public function setNext(?Expert $next): void
    {
        $this->next = $next;
    }
}
