<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_page")
     */
    public function admin( BookRepository $bookRepository, AuthorRepository $authorRepository)
    {
        //je viens chercher tous les livres de ma db
        $books = $bookRepository->findAll();
        $authors = $authorRepository->findAll();
        return $this->render('admin.html.twig',
            [
                'books'=>$books,
                'authors'=>$authors
            ]);
    }

}