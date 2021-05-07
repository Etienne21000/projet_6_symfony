<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Ressource;
use App\Repository\MediaRepository;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RessourceController extends AbstractController
{
    /**
     * @var
     */
    private $manager;

    /**
     * @var
     */
    private $repository;

    /**
     * RessourceController constructor.
     * @param RessourceRepository $ressourceRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(RessourceRepository $ressourceRepository, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->repository = $ressourceRepository;
    }



}