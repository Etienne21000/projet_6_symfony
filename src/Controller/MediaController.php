<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Ressource;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UpdateRessource;
use App\Repository\PostRepository;

class MediaController extends AbstractController
{
    /**
     * @var $manager
     */
    private $manager;

    /**
     * @var $repository
     */
    private $repository;

    private $postRepository;

    /**
     * MediaController constructor.
     * @param MediaRepository $media
     * @param EntityManagerInterface $manager
     * @param PostRepository $postRepository
     */
    public function __construct(MediaRepository $media, EntityManagerInterface $manager, PostRepository $postRepository)
    {
        $this->repository = $media;
        $this->manager = $manager;
        $this->postRepository = $postRepository;
    }

    private function get_single_media(int $id){
        $mediaRepository = $this->getDoctrine()->getRepository(Media::class);

        return $media = $mediaRepository->findOneBy([
            'id' => $id,
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @Route("/delete_media/{id}", name="delete_media")
     */
    public function delete_media(int $id){
        $media = $this->get_single_media($id);
        $media_link = $media->getLink();
        $post_id = $media->getPostId();

        $post = $this->postRepository->findOneBy([
           'id' => $post_id,
        ]);

        $slug = $post->getSlug();

        $this->manager->remove($media);
        $this->manager->flush();

        $this->addFlash('success', 'Le média '.$media_link.' a bien été supprimé');
        return $this->redirectToRoute('update_figure', [
            'slug' => $slug,
        ]);
    }

    /**
     * @param int $id
     * @param int $media_id
     * @param UpdateRessource $updateRessource
     * @Route("update_media/{id}/{media_id}", name="update_media")
     * @return RedirectResponse
     */
    public function update_media(int $id, int $media_id, UpdateRessource $updateRessource){

        $post = $this->postRepository->findOneBy([
            'id' => $id,
        ]);

        $slug = $post->getSlug();

        $updateRessource->update_ressource($id, $media_id);
        $this->addFlash('success', 'Le média à bien été édité');

        return $this->redirectToRoute('update_figure', [
            'slug' => $slug
        ]);
    }

}