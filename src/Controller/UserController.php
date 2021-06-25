<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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

    /**
     * @var UserPasswordEncoderInterface
     */
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
        $param = 'create';

        $user = new User();
        $user->setCreationDate(new \DateTime('now'));
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', 'Votre compte à bien été créé');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('main/add_user_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'user' => $user,
            'param' => $param,
            'form' => $form->createView(),
        ]);
    }

    public function get_u(){
        return $this->getUser()->getUsername();
    }
}