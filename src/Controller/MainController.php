<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Media;
use App\Entity\Ressource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\MediaRepository;
use App\Repository\RessourceRepository;

class MainController extends AbstractController
{
    private $Postrepository;
    private $MediaRepository;
    private $RessourceRepository;

    public function __construct(PostRepository $Postrepository, MediaRepository $mediaRepository, RessourceRepository $ressourceRepository)
    {
        $this->Postrepository = $Postrepository;
        $this->MediaRepository = $mediaRepository;
        $this->RessourceRepository = $ressourceRepository;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        $this->getDoctrine()->getRepository(Post::class);
        $this->getDoctrine()->getRepository(Media::class);

        $post = $this->Postrepository->findBy([
            'status' => 1
        ]);

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
