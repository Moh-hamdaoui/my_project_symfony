<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecetteRepository;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: "text")]
    private ?string $description = null;

    #[ORM\Column(type: "text")]
    private ?string $ingredients = null;

    #[ORM\Column(type: "text")]
    private ?string $preparation = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'recette', orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getIngredients(): array
    {
    
        return $this->ingredients ? json_decode($this->ingredients, true) : [];
    }

    public function setIngredients(array $ingredients): static
    {

        $this->ingredients = json_encode($ingredients);

        return $this;
    }

    public function getPreparation(): ?string
    {
        return $this->preparation;
    }

    public function setPreparation(string $preparation): static
    {
        $this->preparation = $preparation;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setRecette($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRecette() === $this) {
                $comment->setRecette(null);
            }
        }

        return $this;
    }
}
