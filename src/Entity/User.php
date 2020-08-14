<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ResourceEntity;
use App\Controller\Api\UserKeywordsController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *     paginationMaximumItemsPerPage=15,
 *     normalizationContext={
 *         "groups"={
 *             "user:read"
 *         }
 *     },
 *     denormalizationContext={
 *         "groups"={
 *             "user:write"
 *         }
 *     },
 *     collectionOperations={
 *         "post"
 *     },
 *     itemOperations={
 *         "put",
 *         "patch",
 *         "get",
 *         "get_user_with_keywords"={
 *             "method"="GET",
 *             "path"="/user/{id}/keywords",
 *             "controller"=UserKeywordsController::class
 *         }
 *     }
 * )
 */
class User implements UserInterface
{
    use ResourceEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Groups({"user:read", "user:write"})
     * @Assert\Range(min="2", max="100")
     * @Assert\NotBlank
     */
    private $displayName;

    /**
     * @var string | null
     * @ORM\Column(type="text", nullable=true, length=150)
     * @Groups({"user:read", "user:write"})
     */
    private $area;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $areaVisibility;

    /**
     * @var string | null
     * @ORM\Column(length=100, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $bio;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $emailVisibility;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\Choice({"Male", "Female"})
     */
    private $gender;

    /**
     * @var string | null
     * @ORM\Column(type="string", nullable=true, length=15)
     * @Groups({"user:read", "user:write"})
     */
    private $phone;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $phoneVisibility;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Assert\Choice({"Particular", "Professional"})
     */
    private $profile;

    /**
     * @var string | null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $url;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $keywordCount;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $imageCount;

    /**
     * @var string | null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Assert\Url
     */
    private $webSite;

    /**
     * @ORM\OneToMany(targetEntity=Keyword::class, mappedBy="user")
     * @Groups({"user:read", "user:keywords:read"})
     */
    private $keywords;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="userFrom")
     * @Groups({"user:read"})
     */
    private $conversationsFrom;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="userTo")
     * @Groups({"user:read"})
     */
    private $conversationsTo;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="user")
     * @Groups({"user:read"})
     */
    private $images;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->conversationsFrom = new ArrayCollection();
        $this->conversationsTo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return User
     */
    public function setDisplayName(string $displayName): User
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArea(): ?string
    {
        return $this->area;
    }

    /**
     * @param string|null $area
     * @return User
     */
    public function setArea(?string $area): User
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAreaVisibility(): bool
    {
        return $this->areaVisibility;
    }

    /**
     * @param bool $areaVisibility
     * @return User
     */
    public function setAreaVisibility(bool $areaVisibility): User
    {
        $this->areaVisibility = $areaVisibility;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param string|null $bio
     * @return User
     */
    public function setBio(?string $bio): User
    {
        $this->bio = $bio;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailVisibility(): bool
    {
        return $this->emailVisibility;
    }

    /**
     * @param bool $emailVisibility
     * @return User
     */
    public function setEmailVisibility(bool $emailVisibility): User
    {
        $this->emailVisibility = $emailVisibility;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return User
     */
    public function setGender(string $gender): User
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return User
     */
    public function setPhone(?string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPhoneVisibility(): bool
    {
        return $this->phoneVisibility;
    }

    /**
     * @param bool $phoneVisibility
     * @return User
     */
    public function setPhoneVisibility(bool $phoneVisibility): User
    {
        $this->phoneVisibility = $phoneVisibility;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return User
     */
    public function setProfile(string $profile): User
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return User
     */
    public function setUrl(?string $url): User
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return int
     */
    public function getKeywordCount(): int
    {
        return $this->keywordCount;
    }

    /**
     * @param int $keywordCount
     * @return User
     */
    public function setKeywordCount(int $keywordCount): User
    {
        $this->keywordCount = $keywordCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getImageCount(): int
    {
        return $this->imageCount;
    }

    /**
     * @param int $imageCount
     * @return User
     */
    public function setImageCount(int $imageCount): User
    {
        $this->imageCount = $imageCount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebSite(): ?string
    {
        return $this->webSite;
    }

    /**
     * @param string|null $webSite
     * @return User
     */
    public function setWebSite(?string $webSite): User
    {
        $this->webSite = $webSite;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Keyword[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keyword $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
            $keyword->setUser($this);
        }

        return $this;
    }

    public function removeKeyword(Keyword $keyword): self
    {
        if ($this->keywords->contains($keyword)) {
            $this->keywords->removeElement($keyword);
            // set the owning side to null (unless already changed)
            if ($keyword->getUser() === $this) {
                $keyword->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsFrom(): Collection
    {
        return $this->conversationsFrom;
    }

    public function addConversationFrom(Conversation $conversation): self
    {
        if (!$this->conversationsFrom->contains($conversation)) {
            $this->conversationsFrom[] = $conversation;
            $conversation->setUserFrom($this);
        }

        return $this;
    }

    public function removeConversationFrom(Conversation $conversation): self
    {
        if ($this->conversationsFrom->contains($conversation)) {
            $this->conversationsFrom->removeElement($conversation);
            // set the owning side to null (unless already changed)
            if ($conversation->getUserFrom() === $this) {
                $conversation->setUserFrom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsTo(): Collection
    {
        return $this->conversationsTo;
    }

    public function addConversationTo(Conversation $conversation): self
    {
        if (!$this->conversationsTo->contains($conversation)) {
            $this->conversationsTo[] = $conversation;
            $conversation->setUserFrom($this);
        }

        return $this;
    }

    public function removeConversationTo(Conversation $conversation): self
    {
        if ($this->conversationsTo->contains($conversation)) {
            $this->conversationsTo->removeElement($conversation);
            // set the owning side to null (unless already changed)
            if ($conversation->getUserFrom() === $this) {
                $conversation->setUserFrom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

}
