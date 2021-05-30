<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Media;
use App\Entity\Ressource;
use App\Repository\PostRepository;
use App\Repository\MediaRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private $postrepository;

    /**
     * @var MediaRepository
     */
    private $mediarepository;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var Security
     */
    private $security;

    /**
     * MainController constructor.
     * @param PostRepository $postRepository
     * @param MediaRepository $mediaRepository
     * @param EntityManagerInterface $manager
     * @param Security $security
     * @param CommentRepository $commentRepository
     */
    public function __construct(PostRepository $postRepository, MediaRepository $mediaRepository, EntityManagerInterface $manager, Security $security, CommentRepository $commentRepository)
    {
        $this->postrepository = $postRepository;
        $this->mediarepository = $mediaRepository;
        $this->manager = $manager;
        $this->security = $security;
        $this->commentRepository = $commentRepository;
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

    /**
     * @Route("/back-office-snowtricks", name="back-office")
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function back_office(): Response
    {
        if ($this->security->isGranted('ROLE_USER')) {

            $title = 'Bienvenu sur le back-office SnowTricks';
            $sub = 'Vous pouvez modérer les commentaires dans cette zone';
            $comments = $this->commentRepository->findAll();
            $total_com = $this->commentRepository->count_comments();
            $not_validated = $this->commentRepository->count_comments($status = 0);
            $validated = $this->commentRepository->count_comments($status = 1);

            return $this->render('back/back_office.html.twig', [
                'title' => $title,
                'sub' => $sub,
                'total' => $total_com,
                'not_validated' =>$not_validated,
                'validated' => $validated,
                'comments' => $comments,
            ]);
        } else {
           return $this->redirectToRoute('home');
        }
    }
}
