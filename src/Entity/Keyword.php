<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ResourceEntity;
use App\Repository\KeywordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=KeywordRepository::class)
 * @ApiResource(
 *    normalizationContext={
 *        "groups"={
 *            "keyword:read"
 *        }
 *     },
 *     denormalizationContext={
 *        "groups"={
 *            "keyword:write"
 *        }
 *     },
 *     collectionOperations={
 *        "get",
 *        "post"
 *     },
 *     itemOperations={
 *        "get",
 *        "put",
 *        "patch"
 *     }
 * )
 */
class Keyword
{
    use ResourceEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"keyword:read", "user:read"})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     * @Groups({"keyword:read", "keyword:write", "user:read", "user:write"})
     */
    private $value;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="keywords")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
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
}
