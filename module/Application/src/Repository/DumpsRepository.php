<?php
namespace Application\Repository;
use Doctrine\ORM\EntityRepository;
use Application\Entity\Dumps;
use Application\Service\TestService;
/**
 * This is the custom repository class for User entity.
 */
class DumpsRepository extends EntityRepository
{
    /**
     * Retrieves all users in descending dateCreated order.
     * @return Query
     */
/*    public function findAll()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Dumps::class, 'u')
            ->orderBy('u.created', 'DESC');

        return $queryBuilder->getQuery();
    }
*/
    public function findFilteredBy($ord){

        $svc = new TestService();

    	$entityManager = $this->getEntityManager();
	$queryBuilder = $entityManager->createQueryBuilder();

	$queryBuilder->select('d')->from(Dumps::class, 'd');

	foreach($svc->getTypes() as $onetype){
	    if(array_key_exists($onetype, $ord))
		$queryBuilder->orWhere('d.'.$onetype.' = 1');
	}
	/*
	if(array_key_exists('plastic', $ord))
	    $queryBuilder->orWhere('d.plastic =1');
        if(array_key_exists('metal', $ord))
            $queryBuilder->orWhere('d.metal =1');
        if(array_key_exists('paper', $ord))
            $queryBuilder->orWhere('d.paper =1');
        if(array_key_exists('glass', $ord))
            $queryBuilder->orWhere('d.glass =1');
        if(array_key_exists('cloth', $ord))
            $queryBuilder->orWhere('d.cloth =1');
        if(array_key_exists('tetrapack', $ord))
            $queryBuilder->orWhere('d.tetrapack =1');
        if(array_key_exists('house_tech', $ord))
            $queryBuilder->orWhere('d.houseTech =1');
        if(array_key_exists('lamps', $ord))
            $queryBuilder->orWhere('d.lamps =1');
        if(array_key_exists('batteries', $ord))
            $queryBuilder->orWhere('d.batteries =1');
	*/
	return $queryBuilder->getQuery()->getResult();
    }

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
            ->from(Dumps::class, 'u')
	    ->where('u.id', $id)
            ->orderBy('u.created', 'DESC');

        return $queryBuilder->getQuery();
    }
}
