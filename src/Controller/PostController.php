<?php

namespace App\Controller;

use App\Entity\FigureRequest;
use App\Entity\Media;
use App\Entity\Ressource;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\ImageUploader;
use Symfony\Component\Security\Core\Security;


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

    private $mediaRepository;

    private $security;

    /**
     * PostController constructor.
     * @param PostRepository $post
     * @param MediaRepository $mediaRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(PostRepository $post, MediaRepository $mediaRepository, EntityManagerInterface $manager, Security $security)
    {
        $this->manager = $manager;
        $this->repository = $post;
        $this->mediaRepository = $mediaRepository;
        $this->security = $security;
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
        $action = 'create';

        $figure = new FigureRequest();
        $post = new Post();
        $media = new Media();
        $ressource = new Ressource();

        $post->setCreationDate(new \DateTime('now'));
        $media->setCreationDate(new \DateTime('now'));

        $post->setUserId($this->getUser()->getId());

        $form = $this->createForm(PostType::class, $figure);
        $form->handleRequest($request);
        $link = $figure->mediaLink;

        if($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('image')->getData();

            $post
                ->setTitle($figure->figureTitle)
                ->setContent($figure->figureContent)
                ->setStatus($figure->figureStatus)
                ->setCategory($figure->figureCategory)
                ->setSlug($post->getTitle());

            $this->manager->persist($post);
            $this->manager->flush();

            if($imageFile){
                $fileName = $imageUploader->upload($imageFile);
                $media->setPost($post);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $media->setLink($fileName);
                $ressource->setType(1);
            }
            elseif($link) {
                $media->setPost($post);
                $media->setLink($figure->mediaLink);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $ressource->setType(2);
            }

            if($imageFile || $link){
                $this->manager->persist($media);
                $this->manager->flush();

                $ressource
                    ->setMedia($media)
                    ->setMediaId($media->getId())
                    ->setStatus(0);


                $this->manager->persist($ressource);
                $this->manager->flush();
            }

            $this->addFlash('success', 'La figure à bien été ajoutée');
            return $this->redirectToRoute('single_figure', [
               'slug' => $post->getSlug(),
            ]);
        }

        return $this->render('main/add_post_view.html.twig', [
                'title' => $title,
                'sub' => $sub,
                'form' => $form->createView(),
                'action' => $action,
            ]);
    }

    /**
     * @param string $slug
     * @return object|null
     */
    private function find_signle(string $slug){
        return $post = $this->repository->findOneBy([
            'Slug' => $slug,
        ]);
    }

    /**
     * @param $slug
     * @param Request $request
     * @param ImageUploader $imageUploader
     * @return Response
     * @throws \Exception
     * @Route("update_figure/{slug}", name="update_figure")
     */
    public function update_trick($slug, Request $request, ImageUploader $imageUploader)
    {
        if ($this->security->isGranted('ROLE_USER')){

            $post = $this->find_signle($slug);
        $id = $post->getId();
        $medias = $this->mediaRepository->get_media($id);

        $figure = new FigureRequest();

        $action = "edit";
        $title = 'Editer la figure';
        $sub = 'Editer le trick, vous pouvez également ajouter de nouvelles images ou vidéos';

        $post->setUserId($this->getUser()->getId());

        $media = new Media();
        $ressource = new Ressource();

        $post->setEditionDate(new \DateTime('now'));
        $media->setCreationDate(new \DateTime('now'));

        $form = $this->createForm(PostType::class, $figure);
        $form->handleRequest($request);

        $imageFile = $form->get('image')->getData();
        $link = $figure->mediaLink;

        if($form->isSubmitted() && $form->isValid()){
            $post
                ->setTitle($figure->figureTitle)
                ->setContent($figure->figureContent)
                ->setStatus($figure->figureStatus)
                ->setCategory($figure->figureCategory)
                ->setSlug($post->getTitle());

            $this->manager->persist($post);
            $this->manager->flush();

            if($imageFile){
                $fileName = $imageUploader->upload($imageFile);
                $media->setPost($post);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $media->setLink($fileName);
                $ressource->setType(1);
            }
            elseif($link) {
                $media->setLink($figure->mediaLink);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $ressource->setType(2);
            }

            if($imageFile || $link){
                $this->manager->persist($media);
                $this->manager->flush();

                $ressource
                    ->setMedia($media)
                    ->setMediaId($media->getId())
                    ->setStatus(0);

                $this->manager->persist($ressource);
                $this->manager->flush();
            }

            $this->addFlash('success', 'La figure '.$post->getTitle().' à bien été éditée');
            return $this->redirectToRoute('single_figure', [
                'slug' => $post->getSlug(),
            ]);
        }

            return $this->render('main/add_post_view.html.twig', [
                'title' => $title,
                'sub' => $sub,
                'action' => $action,
                'form' => $form->createView(),
                'id' => $id,
                'post' => $post,
                'post_title' => $post->gettitle(),
                'medias' => $medias,
            ]);
        } else {
            $this->addFlash('error', 'Attention, vous devez être connecté pour modifier une figure');
            return $this->redirectToRoute('app_login');
        }

    }

    /**
     * @param $slug
     * @Route("/figure/{slug}", name="single_figure")
     * @return Response
     */
    public function get_one_figure(string $slug): Response
    {
//        $post = $this->find_signle($title);
        $post = $post = $this->repository->findOneBy([
            'Slug' => $slug,
        ]);
        $id = $post->getId();
        $medias = $this->mediaRepository->get_media($id, $status = null);
        $couv = $this->mediaRepository->get_media($id, $status = 1);

        $title = $post->getTitle();
        $sub = $post->getCategory();

        return $this->render('main/single_figure.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'post' => $post,
            'media' => $medias,
            'couv' => $couv,
        ]);
    }
}
