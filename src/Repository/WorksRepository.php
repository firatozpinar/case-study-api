<?php

namespace App\Repository;

use App\Entity\Works;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Works|null find($id, $lockMode = null, $lockVersion = null)
 * @method Works|null findOneBy(array $criteria, array $orderBy = null)
 * @method Works[]    findAll()
 * @method Works[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorksRepository extends ServiceEntityRepository
{
    /**
     * WorksRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Works::class);
    }

    /**
     * @param int $page
     * @return Paginator
     * @throws \Exception
     */
    public function findLatest(int $page = 1): Paginator
    {
        $qb = $this->createQueryBuilder('p')->orderBy('p.created_at', 'DESC');

        return (new Paginator($qb))->paginate($page);
    }

    public function create()
    {
        return 'hohohooh';
    }
}
