<?php

namespace App\Controller;

use App\Entity\FigureRequest;
use App\Entity\Media;
use App\Entity\Ressource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\ImageUploader;


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
     * @param ImageUploader $imageUploader
     * @return Response
     * @throws \Exception
     * @Route("/addPost", name="addPost")
     */
    public function addPost(Request $request, ImageUploader $imageUploader){
        $title = 'Ajouter une nouvelle figure';
        $sub = 'Ajouter un trick en choisissant sa catégorie';

        $figure = new FigureRequest();

        $post = new Post();
        $media = new Media();
        $ressource = new Ressource();

        $post->setCreationDate(new \DateTime('now'));
        $media->setCreationDate(new \DateTime('now'));

        $post->setUserId($this->getUser()->getId());

        $form = $this->createForm(PostType::class, $figure);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('image')->getData();

            $post
                ->setTitle($figure->figureTitle)
                ->setContent($figure->figureContent)
                ->setStatus($figure->figureStatus)
                ->setCategory($figure->figureCategory);

            $this->manager->persist($post);
            $this->manager->flush();

            $media
                ->setPostId($post->getId());

            if($imageFile){
                $fileName = $imageUploader->upload($imageFile);
                $media->setLink($fileName);
            }

            $this->manager->persist($media);
            $this->manager->flush();

            $ressource
                ->setMediaId($media->getId())
                ->setType($figure->resType)
                ->setStatus(1);

            $this->manager->persist($ressource);
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

    /**
     * @param $id
     * @Route("/figure/{id}", name="single_figure")
     * @return Response
     */
    public function get_one_figure(int $id): Response
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $mediaRepository = $this->getDoctrine()->getRepository(Media::class);
        $resRepository = $this->getDoctrine()->getRepository(Ressource::class);

        $media = $mediaRepository->findBy([
            'post_id' => $id,
        ]);

        $post = $postRepository->findOneBy([
            'id' => $id,
        ]);

        $media_dir = '../public/upload/';

        $title = $post->getTitle();
        $sub = $post->getCategory();

        return $this->render('main/single_figure.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'post' => $post,
            'media' => $media,
            'dir' => $media_dir
        ]);
    }
}
