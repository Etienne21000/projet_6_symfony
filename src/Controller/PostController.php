<?php

namespace App\Controller;

use App\Entity\FigureRequest;
use App\Entity\Media;
use App\Entity\Ressource;
use App\Entity\Comment;
use App\Repository\CommentRepository;
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
use App\Form\CommentType;
use App\Service\Pagination;
use App\Service\ValidationService;


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
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var ValidationService
     */
    private $validator;

    /**
     * PostController constructor.
     * @param PostRepository $post
     * @param MediaRepository $mediaRepository
     * @param CommentRepository $commentRepository
     * @param EntityManagerInterface $manager
     * @param Security $security
     * @param Pagination $pagination
     * @param ValidationService $validator
     */
    public function __construct(PostRepository $post, MediaRepository $mediaRepository, CommentRepository $commentRepository, EntityManagerInterface $manager, Security $security, Pagination $pagination, ValidationService $validator)
    {
        $this->manager = $manager;
        $this->repository = $post;
        $this->mediaRepository = $mediaRepository;
        $this->security = $security;
        $this->commentRepository = $commentRepository;
        $this->pagination = $pagination;
        $this->validator = $validator;
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
        $sub = 'Ajouter un trick en choisissant sa cat??gorie';
        $action = 'create';
        $figure = new FigureRequest();
        $post = new Post();
        $media = new Media();
        $ressource = new Ressource();
        $post->setCreationDate(new \DateTime('now'));
        $media->setCreationDate(new \DateTime('now'));
        $post->setUserId($this->getUser()->getId());
        $post->setStatus(1);
        $form = $this->createForm(PostType::class, $figure);
        $form->handleRequest($request);
        $link = $figure->mediaLink;
        $post_params = $this->repository->findAll();
        foreach ($post_params as $title){
            $resp = $title->getTitle();
            if($resp === $figure->figureTitle){
                $this->addFlash('error', 'Attention, ce titre existe d??j??');
                return $this->redirectToRoute('addPost');
            }
        }
        if($form->isSubmitted() && $form->isValid()){
            $imageFile = $form->get('image')->getData();
            $post
                ->setTitle($figure->figureTitle)->setContent($figure->figureContent)->setCategory($figure->figureCategory)->setSlug($post->getTitle());
            $this->manager->persist($post);
            $this->manager->flush();
            if($imageFile){
                $fileName = $imageUploader->upload($imageFile);
                $media->setPost($post);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $media->setLink($fileName);
                $ressource->setType(1);
            } elseif($link) {
                $media->setPost($post);
                $media->setLink($figure->mediaLink);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $ressource->setType(2);
            }
            if($imageFile || $link){
                $this->manager->persist($media);
                $this->manager->flush();
                $ressource->setMedia($media)->setMediaId($media->getId())->setStatus(0);
                $this->manager->persist($ressource);
                $this->manager->flush();
            }
            $this->addFlash('success', 'La figure ?? bien ??t?? ajout??e');
            return $this->redirectToRoute('single_figure', ['slug' => $post->getSlug(),]);
        }
        return $this->render('main/add_post_view.html.twig', ['title' => $title, 'sub' => $sub, 'form' => $form->createView(), 'action' => $action,]);
    }

    /**
     * @param string $slug
     * @return object|null
     */
    private function find_signle(string $slug){
        return $post = $this->repository->findOneBy(['Slug' => $slug,]);
    }

    /**
     * @param $slug
     * @param Request $request
     * @param ImageUploader $imageUploader
     * @return Response
     * @throws \Exception
     * @Route("/update_figure/{slug}", name="update_figure")
     */
    public function update_trick($slug, Request $request, ImageUploader $imageUploader)
    {
        $post = $this->find_signle($slug);
        $id = $post->getId();
        $medias = $this->mediaRepository->get_media($id);
        $figure = new FigureRequest();
        $action = "edit";
        $title = 'Editer la figure';
        $sub = 'Editer le trick, vous pouvez ??galement ajouter de nouvelles images ou vid??os';
        $post->setUserId($this->getUser()->getId());
        $media = new Media();
        $ressource = new Ressource();
        $post->setEditionDate(new \DateTime('now'));
        $post->setStatus(1);
        $media->setCreationDate(new \DateTime('now'));
        $form = $this->createForm(PostType::class, $figure);
        $form->handleRequest($request);
        $imageFile = $form->get('image')->getData();
        $link = $figure->mediaLink;

        $post_params = $this->repository->findAll();
        foreach ($post_params as $title){
            $resp = $title->getTitle();
            if($resp === $figure->figureTitle){
                if($resp !== $post->getTitle()){
                    $this->addFlash('error', 'Attention, ce titre existe d??j??');
                    return $this->redirectToRoute('update_figure', ['slug' => $post->getSlug(),]);
                }
            }
        }
        if($form->isSubmitted() && $form->isValid()){
            $post->setTitle($figure->figureTitle)->setContent($figure->figureContent)->setCategory($figure->figureCategory)->setSlug($post->getTitle());
            $this->manager->persist($post);
            $this->manager->flush();
            if($imageFile){
                $fileName = $imageUploader->upload($imageFile);
                $media->setPost($post);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $media->setLink($fileName);
                $ressource->setType(1);
            } elseif($link) {
                $media->setLink($figure->mediaLink);
                $media->setPostId($post->getId());
                $media->setPostSlug($post->getSlug());
                $ressource->setType(2);
            }
            if($imageFile || $link){
                $this->manager->persist($media);
                $this->manager->flush();
                $ressource->setMedia($media)->setMediaId($media->getId())->setStatus(0);
                $this->manager->persist($ressource);
                $this->manager->flush();
            }
            $this->addFlash('success', 'La figure '.$post->getTitle().' ?? bien ??t?? ??dit??e');
            return $this->redirectToRoute('single_figure', ['slug' => $post->getSlug(),]);
        }
        return $this->render('main/add_post_view.html.twig', ['title' => $title, 'sub' => $sub, 'action' => $action, 'form' => $form->createView(), 'id' => $id, 'post' => $post, 'post_title' => $post->gettitle(), 'medias' => $medias,]);
    }

    /**
     * @param string $slug
     * @param Request $request
     * @param int $page
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Route("/figure/{slug}/{page<\d+>?1}", name="single_figure")
     */
    public function get_one_figure(string $slug, Request $request, int $page)
    {
        $com = new Comment();
        $user = $this->getUser();
        $post = $this->repository->findOneBy(['Slug' => $slug,]);
        $id = $post->getId();
        $count = $this->commentRepository->count_comments_per_post($id);
        $paginate = $this->pagination->pagination($count, $request);
        $comments = $this->commentRepository->get_comments($id, $status = 1, $paginate['first'], $paginate['perPage']);
        $medias = $this->mediaRepository->get_media($id, $status = null);
        $couv = $this->mediaRepository->get_media($id, $status = 1);
        $title = $post->getTitle();
        $sub = $post->getCategory();
        $form = $this->createForm(CommentType::class, $com);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $com->setCreationDate(new \DateTime('now'))->setStatus(0)->setPost($post)->setUser($user);
            $com = $form->getData();
            $this->manager->persist($com);
            $this->manager->flush();
            $this->addFlash('success', 'Votre commentaire ?? bien ??t?? ajout??, il va ??tre soumis ?? validation');
            return $this->redirectToRoute('single_figure', ['slug' => $post->getSlug(),]);
        }
        return $this->render('main/single_figure.html.twig', ['title' => $title, 'sub' => $sub, 'post' => $post, 'media' => $medias, 'couv' => $couv, 'comments' => $comments, 'pages' => $paginate['nbPages'], 'page' => $page, 'form' => $form->createView(),]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete_figure/{id}", name="delete_figure")
     */
    public function delete_figure( int $id ){
        $post = $this->repository->findOneBy(['id' => $id]);
        $this->manager->remove($post);
        $this->manager->flush();
        $this->addFlash('success', 'La figure '.$post->getTitle().' ?? bien ??t?? supprim??e');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/figures", name="figures")
     */
    public function get_all_figures(): Response
    {
        $title = 'Liste des figures de snowboard';
        $subtitle = 'Tricks de snowboard';
        $post = $this->repository->findBy(['status' => 1,], ['category' => 'ASC']);
        foreach ($post as $p){$post_id = $p->getId();}
        $media = $this->mediaRepository->get_media($post_id);
        return $this->render('main/all_figures.html.twig', ['title' => $title, 'sub' => $subtitle, 'post' => $post, 'medias' => $media,]);
    }
}
