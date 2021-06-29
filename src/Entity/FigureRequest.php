<?php

namespace App\Entity;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Post;
use App\Repository\PostRepository;

/**
 * Class FigureRequest
 * @package App\Entity
 */
class FigureRequest
{
    /**
     * @var string
     * @Assert\NotBlank(message = "Attention, le contenu est vide")
     */
    public $figureTitle;

    /**
     * @var string
     * @Assert\NotBlank(message = "Attention, le contenu est vide")
     */
    public $figureContent;

    /**
     * @var
     */
    public $figureCreaDate;

    /**
     * @var
     */
    public $figureUpdate;

    /**
     * @var integer
     */
    public $figureStatus;

    /**
     * @var integer
     */
    public $figureUserId;

    /**
     * @var string
     */
    public $figureCategory;

    /**
     * @var string
     */
    public $mediaLink;

    /**
     * @var integer
     */
    public $mediaPostId;

    /**
     * @var
     */
    public $mediaCreaDate;

    /**
     * @var
     */
    public $mediaUpdate;

    /**
     * @var integer
     */
    public $resMediaId;

    /**
     * @var integer
     */
    public $resType;

    /**
     * @var integer
     */
    public $resStatus;

   /* public function validate_title(){
        $post = new Post;
        $repository = new PostRepository();

        $all = $repository->findAll();
        foreach ($all as $title){
            $resp_title = $title->getTitle();
            if($resp_title = $this->figureTitle){
                echo "Attention ce titre existe déjà";
                exit();
            }
        }
    }*/
}