<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait ResourceEntity
{
    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write", "keyword:read", "keyword:write"})
     */
    private $createdAt;

    /**
     * @var integer | null
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write", "keyword:read", "keyword:write"})
     */
    private $deletedAt;

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDeletedAt(): ?int
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?int $deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }


}