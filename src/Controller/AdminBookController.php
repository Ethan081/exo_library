<?php


namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AdminBookController extends AbstractController
{
//------------------------------------Je cree un form d ajout de livre-----------------------------------------
    /**
     * @Route("/admin/book/formBookAdd", name="adminFormAddBook_page")
     */
    public function formBook(Request $request, EntityManagerInterface $entityManager)
    {
        //je cree une instance de ma class Book()
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        //creation de la view du formulaire
        $bookFormView = $form->createView();
        if ($request->isMethod('POST'))
        {
            //Le formulaire recupere les infos
            //de la requete
            $form->handleRequest($request);
            //Je persiste mes info de mon form.
            $entityManager->persist($book);
            //J envoie les infos de mon form a ma db author.
            $entityManager->flush();
            //Message qui m indique que c est ajouter
            //var_dump('C\'est enregistrer' );die;
        }
        return $this->render('admin/adminBookForm.html.twig',
        [
            'bookFormView'=>$bookFormView
        ]

        );


    }
    //--------------------------------form pour modifier le livre-----------------------------------
    /**
     * @Route("/admin/book/formBookUpdate/{id}", name="formBookUpdate_page")
     */
    public function formBookUpdate($id, BookRepository $bookRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $book = $bookRepository->find($id);

        $form = $this->createForm(BookType::class, $book);
        //creation de la view du formulaire
        $bookFormUpdateView = $form->createView();
        //Si la methode est POST
        //Si le formulaire est envoye
        if ($request->isMethod('POST'))
        {
            //Le formulaire recupere les infos
            //de la requete
            $form->handleRequest($request);
            //je verifie si mes champs du formulaire son valide
            if ($form->isValid()){

                $entityManager->persist($book);
                $entityManager->flush();
                var_dump('C est modifier et envoyer dans la db');die;
            }


        }
        return $this->render('admin/adminBookFormUpdate.html.twig',
            [
                'bookFormUpdateView'=>$bookFormUpdateView
            ]
        );

    }


}