<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Entity\Post;
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
        $post->setUserId($this->getUser()->getId());

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($post);
            $this->manager->flush();
            $this->addFlash('success', 'La figure à bien été ajoutée');
            return $this->redirectToRoute('home');
        }

        return $this->render('main/add_post_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'form' => $form->createView(),
        ]);
    }

    /*public function get_tricks(){
        //$this->repository->findAll();
        $this->getDoctrine()->getRepository(Post::class);
        $post = $this->repository->findAll();

        return $this->render('')
    }*/
}
