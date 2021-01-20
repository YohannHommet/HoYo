<?php


namespace App\Entity;


use App\Entity\Traits\Timestampable;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{

    use Timestampable;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="Title should be at least 3 characters")
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=10, minMessage="Description should be at least 10 characters")
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $image;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }


    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }


    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }


    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

}
