<?php


namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    // je cree une route
    /**
     * @Route("/author/list", name="authorList")
     */
    // '$authorRepository' est une instance de la class 'AuthorRepository'.
    public function authorList(AuthorRepository $authorRepository)
    {
    //j'assigne a la variable $author l'instance '$authorRepository' et sa methode 'findAll()'
        $authors = $authorRepository->findAll();
    //debug var_dum pour afficher ma variable $author.
    // dump($authors);die;
        return $this->render('authorList.html.twig',
            [
                'authors' => $authors
            ]
        );
    }


    // Je cree ma route authorshow
    /**
     * @Route("/author/show/{id}", name="authorShow")
     */
    //je cree une methode authorShow qui a comme argument la class 'AuthorRepository ' et l' instance de class '$authorRepository'
    public function authorShow(AuthorRepository $authorRepository, $id)
    {
        // j'assigne a la variable $author , la methode 'find(id)' de mon instance de class '$authorRepository'
        $author = $authorRepository->find($id);

        //dump($author); die;
        return $this->render('authorShow.html.twig',
            [
               'author'=> $author
            ]
        );
    }



}