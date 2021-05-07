<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $edition_date;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Attention, vous devez ajouter un fichier")
     */
    private $link;

    /**
     * @ORM\Column(type="integer")
     */
    private $post_id;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="media")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\OneToOne(targetEntity=Ressource::class, mappedBy="media", cascade={"persist", "remove"})
     */
    private $ressource;

    /*public function getStatus(): ?int
    {
        return $this->status;
    }*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getEditionDate(): ?\DateTimeInterface
    {
        return $this->edition_date;
    }

    public function setEditionDate(?\DateTimeInterface $edition_date): self
    {
        $this->edition_date = $edition_date;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    public function setPostId(int $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setRessource(Ressource $ressource): self
    {
        // set the owning side of the relation if necessary
        if ($ressource->getMedia() !== $this) {
            $ressource->setMedia($this);
        }

        $this->ressource = $ressource;

        return $this;
    }
}
