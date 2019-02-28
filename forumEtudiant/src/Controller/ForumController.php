<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Sujet;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\SujetType;
use App\Repository\CommentRepository;
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

            return $this->redirectToRoute('mes_sujet');
        }


        return $this->render('forum/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    //monter un sujet
    /**
     * @Route("/show/{id}", name="show_sujet")
     */

    public function showSujet($id, SujetRepository $repository, Request $request, ObjectManager $manager,CommentRepository $repoComment){
        $sujet = $repository->find($id);
        $comment = new Comment();

        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $comment->setSujet($sujet);
            $comment->setCreatedAt(new \DateTime());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute("show_sujet",['id' => $sujet ->getId()]);
        }
        $commentaires =$repoComment->findBy([],array('id' => 'DESC'));
        return $this-> render('forum/show.html.twig',[
            'sujet' => $sujet,
            'form' =>$form->createView(),
            'comments' =>$commentaires
        ]);
    }

    //mes sujets

    /**
     * @Route("mesSujets", name ="mes_sujet")
     */
    public function mesSujets(UserRepository $repoUser){
        $idUser = $this->getUser()->getId();
        //ici j'ai recupere l'id de l'utilisateur connecté
        $user = $repoUser->find($idUser);
        //ici j'ai recupere l'utilisateur connecte a partir de son id
        $mesSujets = $user->getSujetuser();
        #la j'ai chercher tous les sujets qu'il a poste

        return $this->render('forum/messujet.html.twig',[
            'mesSujets' =>$mesSujets
        ]);
    }

    /**
     * @Route("/edit/{id}", name ="edit_sujet")
     */
    public function edit($id, SujetRepository $repository, Request $request,ObjectManager $manager){


        $sujet = $repository->find($id);

        $form = $this->createForm(SujetType::class,$sujet);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $manager->flush();
                return $this->redirectToRoute('mes_sujet');
            }
        }


        return $this ->render('/forum/edit.html.twig',[
            'sujet'=>$sujet,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name ="delete_sujet")
     */
    public function delete($id, SujetRepository $repository,ObjectManager $manager){

        $sujet = $repository->find($id);

        $manager->remove($sujet);
        $manager->flush();
        return $this ->redirectToRoute('mes_sujet');
    }

    /**
     * @Route("/edited", name="edited_sujet")
     */
    public function edited(Request $request){


      return $this->redirectToRoute('mes_sujet');
    }
}
