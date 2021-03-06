<?php

namespace App\Entity;


use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="Need at least 3 characters lenrgth")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string $slug;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category", orphanRemoval=false)
     */
    private $articles;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getName();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }


    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }
        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }
        return $this;
    }

}
