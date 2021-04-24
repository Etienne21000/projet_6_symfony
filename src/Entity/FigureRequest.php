<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

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
}