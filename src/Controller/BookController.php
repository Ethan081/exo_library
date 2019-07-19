<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
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
    public function bookGenre(BookRepository $bookRepository, Request $request)
    {
        $genre = $request->query->get('genre');
        $BookGenre = $bookRepository->findByGenre($genre);

        return $this->render('bookGenre.html.twig',
        [
            'genre'=>$BookGenre
        ]);
    }
    //--------------------------------INSERT d un livre en BD Book---------------------------------------------
    /**
     * @Route("/book/insert", name="insert_page")
     */
    //je mets en parametre de la methode l entity manger
    //car c est l outil qui me permet de gerer mes entites.
    public function insertBook(EntityManagerInterface $entityManager, AuthorRepository $authorRepository)
    {
        //je recupere un auteur en fonction de son id
        $author = $authorRepository->find(1);
        //je cree une nouvelle instance de l entite Book
        // c est cette entite qui est le miroir de la table Book
        $book = new Book();
        // je set toutes les infos de mon livres grace aux setters
        //crees dans l entite
        $book->setTitle('Code93');
        $book->setGenre('Fiction');
        $book->setNumberOfPages(240);
        $book->setSummary('Un cadavre, émasculé, qui rouvre les yeux sur la table d\'autopsie.
         Un portable qui se met à sonner dans le corps d\'un jeune toxico, mort de brûlures inexplicables.
          Malgré quinze ans de terrain en Seine-Saint-Denis, Victor Coste, capitaine de police,');
        //j utilise le setter d auteur(dans l entite Book) pour relier un auteur
        //a mon livre
        $book->setAuthor($author);
        // j'enregistre mon livre en base de données
        // avec les méthodes persist() et flush()
        $entityManager->persist($book);
        $entityManager->flush();
        //j affiche un var dump qui pas  avoir de message d erreur.
        var_dump('C est enregister');die;
    }

    //----------------------Je REMOVE un livre de ma  base de donnee-----------------------------------

    /**
     * @Route("/book/{id}/delete", name="deleteBook_page")
     * Je recupere la valeur de la wildcard {id} dans la variable id
     * Je recupare le bookRepository car j ai besoin d utiliser la methode find()
     * Je recupere l entityManager car c est lui qui me permet de gerer les entités (ajout, suppression, modif)
     */
    public function deleteBook($id, BookRepository $bookRepository,EntityManagerInterface $entityManager)
    {
        // je récupère le livre dans la BDD qui a l'id qui correspond à la wildcard
        // ps : c'est une entité qui est récupérée
        $book = $bookRepository->find($id);

        // j'utilise la méthode remove() de l'entityManager en spécifiant
        // le livre à supprimer
        $entityManager->remove($book);
        $entityManager->flush();

        var_dump('C est suprimmee');die;
    }

    //-----------------------------------Je UPDATE un livre  de ma db--------------------------------------

    /**
     * @Route("/book/{id}/update", name="updateBook_page")
     * Je récupère la valeur de la wildcard {id} dans la variable id
     * Je récupère le bookRepository car j'ai besoin d'utiliser la méthode find
     * Je récupère l'entityManager car c'est lui qui me permet de gérer les entités (ajout, suppression, modif)
     */
    public function updateBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager, AuthorRepository $authorRepository)
    {
        //je recupere un auteur en fonction de son id
        $author = $authorRepository->find(3);
        // je récupère ;le livre dans la BDD qui a l'id qui correspond à la wildcard
        $book = $bookRepository->find($id);

        // j'utilise le setter du titre pour modifier le titre du livre
        $book->setTitle('Le Fantome Amoureux');
        //j utilise le setter d auteur(dans l entite Book) pour relier un auteur
        //a mon livre
        $book->setAuthor($author);

        // je re-enregistre le livre dans la base de données
        $entityManager->persist($book);
        $entityManager->flush();

        var_dump('Le livre est bien mis a jour');die;
    }

}