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

    private function get_medias(int $id) {
        $medias = $this->mediaRepository->get_media($id, $status = 1);
        return $medias;
    }

    /**
     * @param int $id
     */
    public function unset_couv(int $id){

        $medias = $this->get_medias($id);

        foreach ($medias as $m){
            $id = $m->getId();
            $ressource = $this->resRepository->findOneBy([
                'media_id' => $id,
            ]);
            $ressource->setStatus(0);

            $this->manager->persist($ressource);
            $this->manager->flush();
        }
    }

    /**
     * @param int $id
     * @param int $media_id
     */
    public function update_ressource(int $id, int $media_id){
        $this->unset_couv($id);

        $ressource = $this->resRepository->findOneBy([
           'media_id' => $media_id,
        ]);
        $ressource->setStatus(1);
        $this->manager->persist($ressource);
        $this->manager->flush();
    }

}