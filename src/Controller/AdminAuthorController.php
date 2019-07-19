<?php


namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminAuthorController extends AbstractController
{
    //------------------------------------Je cree un form d ajout d Auteur-----------------------------------------
    /**
     * @Route("/admin/author/formAuthorAdd", name="adminFormAuthor_page")
     */
    public function formAuthor(Request $request, EntityManagerInterface $entityManager )
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        //creation de la view du formulaire
        $authorFormView = $form->createView();
        //Si la methode est POST
        //Si le formulaire est envoye
        if ($request->isMethod('Post'))
        {
            //Le formulaire recupere les infos
            //de la requete
            $form->handleRequest($request);
            //Je persiste mes info de mon form.
            $entityManager->persist($author);
            //J envoie les infos de mon form a ma db author.
            $entityManager->flush();
            var_dump('c\'est envoyer');die;

        }

        return $this->render('adminAuthorForm.html.twig',
            [
                'authorFormView'=>$authorFormView
            ]
        );
    }
    //--------------------------------Je cree un form pour modifier d Auteur-----------------------------------
    /**
     * @Route("/admin/author/formAuthorUpdate/{id}", name="formAuthorUpdate_page")
     */
    public function formAuthorUpdate($id, AuthorRepository $authorRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $author = $authorRepository->find($id);

        $form = $this->createForm(AuthorType::class, $author);
        //creation de la view du formulaire
        $authorFormUpdateView = $form->createView();
        //Si la methode est POST
        //Si le formulaire est envoye
        if ($request->isMethod('POST'))
        {
            //Le formulaire recupere les infos
            //de la requete
            $form->handleRequest($request);
            //je verifie si mes champs du formulaire son valide
            if ($form->isValid()){

                $entityManager->persist($author);
                $entityManager->flush();
                var_dump('C est modifier et envoyer dans la db');die;
            }


        }
        return $this->render('adminAuthorFormUpdate.html.twig',
            [
                'authorFormUpdateView'=>$authorFormUpdateView
            ]
        );

    }

}