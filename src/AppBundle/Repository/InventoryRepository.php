<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * This custom Doctrine repository contains some methods which are useful when
 * querying for blog post information.
 * See http://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class InventoryRepository extends EntityRepository
{
//    public function __construct() {
//        self::parent();
//        exit(' ke sini');
//    }
    public function findBySearchResult($fieldOption=null, $keyWord=null)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT *
                FROM AppBundle:Inventory AS i
                WHERE i.' . $fieldOption . ' LIKE :keyWord
                ORDER BY i.id ASC
            ')
            ->setParameter('keyWord', "%" . $keyWord . "%")->getResult();
    }

}
