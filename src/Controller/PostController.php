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
            return $this->redirectToRoute('single_figure', [
               'id' => $post->getId(),
            ]);
        }

        return $this->render('main/add_post_view.html.twig', [
            'title' => $title,
            'sub' => $sub,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $id
     * @return object|null
     */
    private function find_signle(int $id){
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        return $post = $postRepository->findOneBy([
            'id' => $id,
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function get_media(int $id){
        $mediaRepository = $this->getDoctrine()->getRepository(Media::class);

        return $medias = $mediaRepository->get_media($id);
    }

    public function get_couv_media(int $id){
        $mediaRepository = $this->getDoctrine()->getRepository(Media::class);

        $limit = 1;
        $offset = 0;

        return $mediaRepository->get_status($id, $limit, $offset);
    }

    /**
     * @param int $id
     * @param Request $request
     * @param ImageUploader $imageUploader
     * @return Response
     * @Route("update_figure/{id}", name="update_figure")
     * @throws \Exception
     */
    public function update_trick($id, Request $request, ImageUploader $imageUploader)
    {
        $post = $this->find_signle($id);
        $medias = $this->get_media($id);

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
                ->setCategory($figure->figureCategory);

            $this->manager->persist($post);
            $this->manager->flush();

            if($imageFile){
                $fileName = $imageUploader->upload($imageFile);
                $media->setPostId($post->getId());
                $media->setLink($fileName);
                $ressource->setType(1);
            }
            elseif($link) {
                $media->setLink($figure->mediaLink);
                $media->setPostId($post->getId());
                $ressource->setType(2);
            }

            if($imageFile || $link){
                $this->manager->persist($media);
                $this->manager->flush();

                $ressource
                    ->setMediaId($media->getId())
                    ->setStatus(1);

                $this->manager->persist($ressource);
                $this->manager->flush();
            }

            $this->addFlash('success', 'La figure '.$post->getTitle().' à bien été éditée');
            return $this->redirectToRoute('single_figure', [
                'id' => $post->getId(),
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
    }

    /**
     * @param $id
     * @Route("/figure/{id}", name="single_figure")
     * @return Response
     */
    public function get_one_figure(int $id): Response
    {
        $medias = $this->get_media($id);
        $post = $this->find_signle($id);
        $couv = $this->get_couv_media($id);

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
