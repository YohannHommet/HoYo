<?php

namespace App\Entity\Traits;


use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;


/**
 * Trait Timestampable
 *
 * @package App\Entity\Traits
 * @ORM\HasLifecycleCallbacks()
 */
trait Timestampable
{

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private ?DateTimeInterface $updatedAt;


    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @param \DateTimeInterface|null $createdAt
     * @return \App\Entity\Traits\Timestampable
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @param \DateTimeInterface|null $updatedAt
     * @return \App\Entity\Traits\Timestampable
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}