<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 13:53
 */

namespace PPHI\DAO;

use PPHI\Entity\EntityManager;
use PPHI\PPHI;

abstract class DAO
{
    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return PPHI::getInstance()->getEntityManager();
    }
}
