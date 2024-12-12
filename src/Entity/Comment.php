<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recette $recette = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->OneToMany = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getRecette(): ?Recette
    {
        return $this->recette;
    }

    public function setRecette(?Recette $recette): static
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getOneToMany(): Collection
    {
        return $this->OneToMany;
    }

    public function addOneToMany(user $oneToMany): static
    {
        if (!$this->OneToMany->contains($oneToMany)) {
            $this->OneToMany->add($oneToMany);
            $oneToMany->setComment($this);
        }

        return $this;
    }

    public function removeOneToMany(user $oneToMany): static
    {
        if ($this->OneToMany->removeElement($oneToMany)) {
            // set the owning side to null (unless already changed)
            if ($oneToMany->getComment() === $this) {
                $oneToMany->setComment(null);
            }
        }

        return $this;
    }
}
