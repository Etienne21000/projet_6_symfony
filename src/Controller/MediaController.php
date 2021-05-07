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

    /**
     * MediaController constructor.
     * @param MediaRepository $media
     * @param EntityManagerInterface $manager
     */
    public function __construct(MediaRepository $media, EntityManagerInterface $manager)
    {
        $this->repository = $media;
        $this->manager = $manager;
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

        $this->manager->remove($media);
        $this->manager->flush();

        $this->addFlash('success', 'Le média '.$media_link.' a bien été supprimé');
        return $this->redirectToRoute('update_figure', [
            'id' => $post_id,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateRessource $updateRessource
     * @Route("update_media/{id}", name="update_media")
     * @return RedirectResponse
     */
    public function update_media(int $id, UpdateRessource $updateRessource){
        $updateRessource->unset_couv($id);
        $this->addFlash('success', 'Le média à bien été édité');
        return $this->redirectToRoute('single_figure', [
            'id' => $id
        ]);
        /*$mediaRepository = $this->getDoctrine()->getRepository(Media::class);

        $media = $mediaRepository->get_status($id);

//        $media->getStatus()
        foreach ($media as $data){
            $status = $data->getStatus();
        }*/
    }

}