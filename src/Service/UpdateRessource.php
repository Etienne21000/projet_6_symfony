<?php

namespace App\Service;

use App\Entity\Media;
use App\Entity\Ressource;
use App\Repository\MediaRepository;
use App\Repository\PostRepository;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;

class UpdateRessource
{
    private $postRepository;
    private $mediaRepository;
    private $resRepository;
    private $manager;

    /**
     * UpdateRessource constructor.
     * @param RessourceRepository $ressourceRepository
     * @param MediaRepository $mediaRepository
     * @param PostRepository $postRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(RessourceRepository $ressourceRepository, MediaRepository $mediaRepository, PostRepository $postRepository, EntityManagerInterface $manager)
    {
        $this->postRepository = $postRepository;
        $this->mediaRepository = $mediaRepository;
        $this->resRepository = $ressourceRepository;
        $this->manager = $manager;
    }

    /**
     * @param int $id
     */
    public function unset_couv(int $id){
//        $media = new Media();
//        $ressource = new Ressource();

        $medias = $this->mediaRepository->get_media($id, $status = 1);

        foreach ($medias as $m){
            $id = $m->getId();
            $ressource = $this->resRepository->findOneBy([
                'id' => $id,
            ]);
            $ressource->setStatus(0);

            $this->manager->persist($ressource);
            $this->manager->flush();
        }
    }

    /**
     * @param int $id
     * @Route("update_media/{id}", name="update_media")
     */
    public function update_ressource(int $id){
        $this->unset_couv($id);
    }

}