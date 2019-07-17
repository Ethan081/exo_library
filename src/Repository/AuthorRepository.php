<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findByLastName()
    {
        $lastName = 'Levy';

        $qb = $this->createQueryBuilder('a');
        $query = $qb->select('a')
            ->where('a.last_name = :lastName')
            ->setParameter('lastName', $lastName)
            ->getQuery();
        $resultats = $query->getArrayResult();
        return $resultats;
    }


    //methode pour trouver des auteurs en fonction d un mot de leur biographie
    // creer la methode qui fait la requete SQL
    //creer la route(dans la classe de controller)
    //creer la methode de controler liee a a route
    //appeler la methode du repository(celle qui fait la requete SQL)
    //enregistrer les resultats de la requete SQL dans une variable
    //afficher la variable.

    public function findAuthorByBio($bio)
    {
//        $bio = 'Fils';

        $qb = $this->createQueryBuilder('a');
        $query = $qb->select('a')
            ->where('a.bio LIKE :word')
            //je securise ma requete avec la methode setParameter.
            ->setParameter('word','%'.$bio.'%')
            ->getQuery();
        $resultats = $query->getArrayResult();
        return $resultats;
    }



}
