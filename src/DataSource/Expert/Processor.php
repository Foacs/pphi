<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 09/05/19
 * Time: 17:24
 */

namespace PPHI\DataSource\Expert;

use PPHI\DataSource\Source\DataSource;

class Processor
{

    /**
     * @var Expert
     */
    private $expert;

    public function execute(string $str): ?DataSource
    {
        if (!is_null($this->expert)) {
            return $this->expert->execute($str);
        }
        return null;
    }

    public function pushExpert(Expert $expert): void
    {
        $tmp = $this->expert;
        $expert->setNext($tmp);
        $this->expert = $expert;
    }

    /**
     * @return Expert
     */
    public function getExpert(): ?Expert
    {
        return $this->expert;
    }
}
