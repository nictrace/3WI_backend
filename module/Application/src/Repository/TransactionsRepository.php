<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Transaction;
use Application\Service\TestService;
/**
 * This is the custom repository class for User entity.
 */
class TransactionsRepository extends EntityRepository
{
	public function findSummed($id, $mode = 2){

	    //$svc = new TestService();
	    //return $svc->getTypes();

            $entityManager = $this->getEntityManager();
            $queryBuilder = $entityManager->createQueryBuilder();

            $queryBuilder->select('SUM(t.weight) as sumweight')->from(Transaction::class, 't')
		->groupBy('t.userId')
		->where('t.userId = ?1')
		->setParameter(1, $id);

	    return $queryBuilder->getQuery()->getSingleScalarResult();;
	}
}
