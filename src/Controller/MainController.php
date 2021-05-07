<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Media;
use App\Entity\Ressource;
use App\Repository\PostRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $postrepository;
    private $mediarepository;
    private $manager;

    /**
     * MainController constructor.
     * @param PostRepository $postRepository
     * @param MediaRepository $mediaRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(PostRepository $postRepository, MediaRepository $mediaRepository, EntityManagerInterface $manager)
    {
        $this->postrepository = $postRepository;
        $this->mediarepository = $mediaRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        //$postRepository = $this->getDoctrine()->getRepository(Post::class);
        $post = $this->postrepository->findBy([
            'status' => 1,
        ]);

        foreach ($post as $p){
            $post_id = $p->getId();
        }

        $media = $this->mediarepository->get_media($post_id);

        // Add other repositories requestes to find Media and ressource type
        $title = 'SnowTricks';
        $subtitle = 'Tricks de snowboard';

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'title' => $title,
            'sub' => $subtitle,
            'post' => $post,
            'medias' => $media,
        ]);
    }
}
