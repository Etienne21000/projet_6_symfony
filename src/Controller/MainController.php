<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Media;
use App\Entity\Ressource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
//    private $Postrepository;
//    private $MediaRepository;
//    private $RessourceRepository;

    public function __construct()
    {
//        $this->Postrepository = $this->getDoctrine()->getRepository(Post::class);
//        $this->MediaRepository = $this->getDoctrine()->getRepository(Media::class);
//        $this->RessourceRepository = $this->getDoctrine()->getRepository(Ressource::class);
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $post = $postRepository->findBy([
            'status' => 1,
        ]);

        /*$media = $this->MediaRepository->findBy([
            'post_id' => $Post->getId(),
        ]);*/

        // Add other repositories requestes to find Media and ressource type
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
