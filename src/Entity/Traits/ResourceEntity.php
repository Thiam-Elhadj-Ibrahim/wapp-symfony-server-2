<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Trait ResourceEntity
 * @package App\Entity\Traits
 */
trait ResourceEntity
{
    /**
     * @var integer | null
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write", "keyword:read", "keyword:write", "conversation:read", "conversation:write", "chat:read", "chat:write", "image:read", "image:write"})
     */
    private $createdAt;

    /**
     * @var integer | null
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write", "keyword:read", "keyword:write", "conversation:read", "conversation:write", "chat:read", "chat:write", "image:read", "image:write"})
     */
    private $deletedAt;

    /**
     * @return int | null
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @param int|null $createdAt
     * @return $this
     */
    public function setCreatedAt(?int $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDeletedAt(): ?int
    {
        return $this->deletedAt;
    }

    /**
     * @param int|null $deletedAt
     * @return $this
     */
    public function setDeletedAt(?int $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

}