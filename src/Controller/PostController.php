<?php

namespace App\Controller;

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
     * @Route("/addPost", name="addPost")
     */
    public function addPostView(Request $request){
        $title = 'Ajouter une nouvelle figure';
        $sub = 'Ajouter un trick en choisissant sa catégorie';

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        return $this->render('main/add_post_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'form' => $form->createView(),
        ]);
    }
}
