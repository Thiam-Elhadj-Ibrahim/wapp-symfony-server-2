<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ResourceEntity;
use App\Repository\KeywordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KeywordRepository::class)
 * @ApiResource(
 *    paginationMaximumItemsPerPage=15,
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
     * @Assert\NotBlank()
     */
    private $value;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="keywords")
     */
    private $user;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
