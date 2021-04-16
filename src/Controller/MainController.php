<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class MainController extends AbstractController
{
    private $repository;

    /**
     * @Route("/", name="home")
     * @param PostRepository $repository
     * @return Response
     */
    public function index(PostRepository $repository): Response
    {
        $this->repository = $repository;
        $this->getDoctrine()->getRepository(Post::class);
        $post = $this->repository->findAll();

        $title = 'SnowTricks';
        $subtitle = 'Tricks de snowboard';
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'title' => $title,
            'sub' => $subtitle,
            'post' => $post,
        ]);
    }
}
