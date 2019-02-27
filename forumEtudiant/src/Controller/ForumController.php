<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\User;
use App\Form\SujetType;
use App\Repository\SujetRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/", name="sujet_forum")
     */
    public function index(SujetRepository $repository)
    {
        $sujets =$repository->findAll();
        return $this->render('forum/index.html.twig', [
            'sujets' => $sujets
        ]);
    }

    // creation du formulaire de depot du sujet
    /**
     * @Route("/creation", name ="create_sujet")
     */
    public function create(UserRepository $repo, Request $request, ObjectManager $manager){

        $sujet = new Sujet();
        $idUser = $this->getUser()->getId();
        $user = $repo->find($idUser);

        $form = $this->createForm(SujetType::class,$sujet);
        $form->handleRequest($request);
       // var_dump($idUser);

        if($form->isSubmitted() && $form->isValid()){
            $sujet->setCreatedAt(new \DateTime());
            $sujet->setUser($user);
            $manager ->persist($sujet);
            $manager->flush();

            return $this->redirectToRoute('sujet_forum');
        }


        return $this->render('forum/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    //monter un sujet
    /**
     * @Route("/show/{id}", name="show_sujet")
     */

    public function showSujet($id, SujetRepository $repository){

        $sujet = $repository->find($id);
        return $this-> render('forum/show.html.twig',[
            'sujet' => $sujet
        ]);
    }
}
