<?php
namespace Application\Repository;
use Doctrine\ORM\EntityRepository;
use Application\Entity\User;
/**
 * This is the custom repository class for User entity.
 */
class UsersRepository extends EntityRepository
{
    public function findBetween($x1,$x2,$y1,$y2)
    {
	$em = $this->getEntityManager();
	$qb = $em->createQueryBuilder();
	$qb->select('e')->from(Dumps::class, 'e')
	    ->where('e.lon > :xmin')
	    ->andWhere('e.lon < :xmax')
	    ->andWhere('e.lat > :ymin')
	    ->andWhere('e.lat < :ymax')
	    ->setParameter('xmin', $x1)
	    ->setParameter('xmax', $x2)
	    ->setParameter('ymin', $y1)
	    ->setParameter('ymax', $y2);
	return $qb->getQuery()->getResult();
    }
    // findById($id)
    public function findById($id){
	$entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
	    ->where('u.id', $id)
            ->orderBy('u.created', 'DESC');

        return $queryBuilder->getQuery();
    }

    public function findOneByPhone($phone){
	$em = $this->getEntityManager();
	$queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where('u.phone', $phone)
            ->orderBy('u.created', 'DESC');

	return $queryBuilder->getQuery()->getResult();
    }
}
