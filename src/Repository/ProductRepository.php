<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Product $product, bool $flush = false): void
    {
        $this->_em->persist($product);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * 1 Products without stock (order by price desc)
     * 2 Products with stock (order by price asc)
     * 3 Products with special offer (order by price asc)
     * 4 Products with sales (order by price asc)
     * 5 Products with flash sales (order by start date then price asc)
     *
     * @return Product[]
     */
    public function getWeightedProductList(): array
    {
        $result1 = $this->createQueryBuilder('p')
            ->where('p.stock > 0')
            ->orderBy('p.weighting', 'DESC')
            ->addOrderBy('p.specialOffer.startDate', 'DESC')
            ->addOrderBy('p.price', 'ASC')
            ->getQuery()->getResult();

        $result2 = $this->createQueryBuilder('p')
            ->where('p.stock = 0')
            ->orderBy('p.price', 'DESC')
            ->getQuery()->getResult();

        return array_merge($result1, $result2);
    }
}
