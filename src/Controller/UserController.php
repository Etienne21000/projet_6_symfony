<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Validator\Validation;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @var $manager
     */
    private $manager;

    /**
     * @var $repository
     */
    private $repository;

    private $encodePass;

    /**
     * UserController constructor.
     * @param UserRepository $user
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encodePass
     */
    public function __construct(UserRepository $user, EntityManagerInterface $manager, UserPasswordEncoderInterface $encodePass)
    {
        $this->manager = $manager;
        $this->repository = $user;
        $this->encodePass = $encodePass;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws Exception
     * @Route("/addUser", name="addUser")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $title = 'Créer un compte utilisateur';
        $sub = 'Votre compte vous permettra de contribuer à la création d\'articles';

        $user = new User();
        $user->setCreationDate(new \DateTime('now'));
        $user->setRoles(0);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', 'Votre compte à bien été créé');
            return $this->redirectToRoute('addUser');
        }

        return $this->render('main/add_user_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @Route("/connectUser", name="connectUser")
     */
    public function connectUser(Request $request){
        $title = 'Connection espace utilisateur';
        $sub = 'Connectez vous à votre espace utilisateur';

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

    }

}