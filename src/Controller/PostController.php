<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Entity\Post;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\PostRepository;


class PostController extends AbstractController
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
     * PostController constructor.
     * @param PostRepository $post
     * @param EntityManagerInterface $manager
     */
    public function __construct(PostRepository $post, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->repository = $post;
    }

    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @Route("/addPost", name="addPost")
     */
    public function addPost(Request $request){
        $title = 'Ajouter une nouvelle figure';
        $sub = 'Ajouter un trick en choisissant sa catégorie';

        $post = new Post();
        $post->setCreationDate(new \DateTime('now'));
        $validator = Validation::createValidator();

        $errors = $validator->validate($post, [
            new length(['min' => 2]),
            new NotBlank(),
        ]);

        if(0 !== count($errors)){
            foreach ($errors as $error){
                //echo $error->getMessage().'<br>';
            }
        }

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($post);
            $this->manager->flush();
            $this->addFlash('success', 'La figure à bien été ajoutée');
            return $this->redirectToRoute('/');
            //dump($post);
        }

        return $this->render('main/add_post_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'form' => $form->createView(),
        ]);
    }
}
