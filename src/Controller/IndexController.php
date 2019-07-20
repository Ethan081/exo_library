<?php


namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function index(BookRepository $bookRepository, AuthorRepository $authorRepository)
    {
        $books = $bookRepository->findAll();
        $authors = $authorRepository->findAll();
        return $this->render('index.html.twig',
            [
                'books'=>$books,
                'authors'=>$authors
            ]
        );
    }

    /**
     * @Route("/Contact", name="contact_page")
     */
    public function contact(){
        return $this->render('contact.html.twig',
            [

            ]
        );
    }




}