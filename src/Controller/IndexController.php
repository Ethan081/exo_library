<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function index(){
        return $this->render('index.html.twig',
            [

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