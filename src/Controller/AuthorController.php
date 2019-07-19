<?php


namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("author/lastName", name="authorLastName")
     */
    public function authorLastName(AuthorRepository $authorRepository)
    {
        $authorlastName = $authorRepository->findByLastName();

        return $this->render('authorLastName.html.twig',
            [
                'authorlastName' => $authorlastName
//                var_dump($authorlastName);die;
            ]

        );
    }

    /**
     * @Route("author/biographie", name="authorBio")
     */
    //je rajoute en parametre de ma methode la class Request et AuthorRepository
    public function authorBio(AuthorRepository $authorRepository, Request $request)
    {
        //je recupere le valeur de mon URL apres ?bio= leMotEntrer. et je l assigne a une variable $bio.
        $bio = $request->query->get('bio');
//        var_dump($bio);die;
        //je met ma variable $bio en argument de ma methode findAuthorByBio(). Pour qu il aille chercher le mot
        //dans le champ bio de ma db library.
        //Cela me permet de recuperer toutes les infos de l'auteur ayant le mot de url dans sa bio.
        $authorBio = $authorRepository->findAuthorByBio($bio);
//        var_dump($authorBio);die;
        //je cree une vue pour afficher mes auteurs selectionnes
        return $this->render('authorBio.html.twig',
            [
                'authorBio' => $authorBio

        ]
        );
    }
    //je rajoute un auteur en base de donner
    /**
     * @Route("/author/insert", name="insertAuthor_page")
     */
    public function insertAuthor(EntityManagerInterface $entityManager)
    {
        $author = new Author();
        $author->setFirstName('Nicolas');
        $author->setLastName('Beuglet');
        $author->setBirthdate(new \DateTime('1974-01-01'));
        $author->setBio('Nicolas Beuglet est romancier et scénariste.
        Il a été présentateur, rédacteur en chef et directeur artistique en télévision (M6).
        En 2011, il a publié un premier roman, "Le premier crâne", sous le nom de Nicolas Sker.');

        $entityManager->persist($author);
        $entityManager->flush();

        var_dump('C est dans la db');die;


    }

    //Suprimmee un Auteur
    /**
     * @Route("/author/{id}/delete", name="deleteAuthor_page")
     */
    public function deleteAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        var_dump('l\'auteur n\'est plus dans la db.' );die;
    }

    //-----------------------------------------Je met a jour un Auteur----------------------------------------
    /**
     * @Route("author/{id}/update", name="updateAuthor_page")
     */
    public function updateAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        $author = $authorRepository->find($id);

        $author->setLastName('Poquelin dit Moliere');
        $author->setBio('Au tournant de l\'année 1643, Jean-Baptiste Poquelin, d\'ores et déjà émancipé 
        d\'âgen 16 et qui a renoncé à la survivance de la charge de son père, reçoit de 
        celui-ci un important acompte sur l’héritage maternel. Il a quitté la maison de la rue Saint-Honoré 
        et demeure à présent rue de Thorigny, dans le quartier du Marais, non loin des Béjart16.');

        $entityManager->persist($author);
        $entityManager->flush();

        var_dump('C est modifier');die;
    }
}