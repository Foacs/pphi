<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 31/05/19
 * Time: 13:44
 */

namespace PPHI\FunctionalTest\dao;

use PPHI\DAO\DAO;
use PPHI\FunctionalTest\entities\Brand;

class BrandDao extends DAO
{
    /**
     * @param Brand $brand
     *
     * @throws \PPHI\Exception\entity\EntityClassException
     */
    public function save(Brand $brand)
    {
        $this->getEntityManager()->save($brand);
    }
}
