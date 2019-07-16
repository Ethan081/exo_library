<?php


namespace App\Controller;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BookController extends AbstractController
{
    //je cree ma route
    /**
     * @Route("/book/list", name="bookList")
     */
    //Je passe en parametrede la class 'EntityManagerInterface' avec la variable '$entityManager'
    // qui est une instance de la class 'EntityManagerInterface'

//------- une facon de faire
//    public function index(EntityManagerInterface $entityManager)
//
//    {
//        //je cree une variable '$bookRepository', je lui assigne la methode 'getRepository' de
//        //  l instance de class '$entityManager' avec comme parametre le nom de class de mon Entity (Book::class).
//        $bookRepository = $entityManager->getRepository(Book::class);
//
//        //j'utilise la methode findAll() de mon instance de class '$entityManager'.
//        $book = $bookRepository->findAll();
//        //j affiche ma table Book
//        dump($book);die;
//    }
    //------- une autre facon de faire
    public function bookList(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        //j affiche ma table Book
        //dump($books);die;
        return $this->render('booksList.html.twig',
            [
                'books'=>$books
            ]);
    }

//    j utilise la methode fin(id), cela me retourne le livre avec l id voulue.
    /**
     * @Route("/book/show/{id}", name="bookShow")
     */
    public function bookShow(BookRepository $bookRepository, $id)
    {
        $book = $bookRepository->find($id);

        //dump($book);die;
        return $this->render('bookShow.html.twig',
            [
                'book'=>$book
            ]);

    }

    /**
     * @Route("/book/genre", name="bookGenre")
     */
    public function bookGenre(BookRepository $bookRepository)
    {
        $genre = $bookRepository->findByGenre();

        return $this->render('bookGenre.html.twig',
        [
            'genre'=>$genre
        ]);
    }


}