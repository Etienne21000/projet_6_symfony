<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CommentController extends AbstractController
{

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

    public function __construct( EntityManagerInterface $manager, Security $security, CommentRepository $commentRepository)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @Route("/updateComment/{id}", name="update_comment")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function update_comment(int $id, Request $request):Response
    {

        $com = $this->commentRepository->findOneBy(['id' => $id]);

        $com->setStatus(1);

        $this->manager->persist($com);
        $this->manager->flush();

        $this->addFlash('success', 'Le commentaire a bien été validé');

        return $this->redirectToRoute('back-office');
    }

    /**
     * @param int $id
     * @Route("/delete-comment/{id}", name="delete_comment")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete_comment(int $id)
    {
        $comment = $this->commentRepository->findOneBy(['id' => $id]);
        $this->manager->remove($comment);
        $this->manager->flush();
        $this->addFlash('success', 'Le commentaire '.$comment->getId().' a bien été supprimé.');
        return $this->redirectToRoute('back-office');
    }

}