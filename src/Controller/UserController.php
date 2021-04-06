<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use App\Entity\User;
use App\Repository\UserRepository;

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
     * UserController constructor.
     * @param UserRepository $user
     * @param EntityManagerInterface $manager
     */
    public function __construct(UserRepository $user, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->repository = $user;
    }

    /**
     * @param Request $request
     * @Route("/addUser", name="addUser")
     * @return Response
     * @throws \Exception
     */
    public function addUser(Request $request){

        $title = 'Créer un compte utilisateur';
        $sub = 'Votre compte vous permettra de contribuer à la création d\'articles';

        $user = new User();
        $user->setCreationDate(new \DateTime('now'));

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('success', 'Votre compte à bien été créé');
            return $this->redirectToRoute('/');
        }

        return $this->render('main/add_user_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'form' => $form->createView(),
        ]);
    }

}