<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/register", name="register_security")
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);
        if($form ->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user ->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login_security');
        }

        return $this->render('user/register.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/login", name ="login_security")
     */
    public function login(){

        return $this->render('user/login.html.twig');
    }
    /**
     * @Route("/logout", name ="logout_security")
     */
    public function logout(){}
}
