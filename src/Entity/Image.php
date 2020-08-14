<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ResourceEntity;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ApiResource(
 *    paginationMaximumItemsPerPage=15,
 *    normalizationContext={
 *        "groups"={
 *            "image:read"
 *        }
 *     },
 *     denormalizationContext={
 *        "groups"={
 *            "image:write"
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
class Image
{
    use ResourceEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"image:read", "user:read",})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"image:read", "image:write", "user:read", "user:write"})
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="images")
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
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

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
