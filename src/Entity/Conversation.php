<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ResourceEntity;
use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 * @ApiResource(
 *     paginationMaximumItemsPerPage=15,
 *     normalizationContext={
 *         "groups"={
 *             "conversation:read"
 *         }
 *     },
 *     denormalizationContext={
 *         "groups"={
 *             "conversation:write"
 *         }
 *     },
 *     collectionOperations={
 *         "get",
 *         "post"
 *     },
 *     itemOperations={
 *         "get",
 *         "put",
 *         "patch"
 *     }
 * )
 */
class Conversation
{
    use ResourceEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"conversation:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversationsFrom")
     */
    private $userFrom;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversationsTo")
     */
    private $userTo;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="conversation")
     * @Groups({"conversation:read"})
     */
    private $chats;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserFrom(): ?User
    {
        return $this->userFrom;
    }

    public function setUserFrom(?User $userFrom): self
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    public function getUserTo(): ?User
    {
        return $this->userTo;
    }

    public function setUserTo(?User $userTo): self
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setConversation($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->contains($chat)) {
            $this->chats->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getConversation() === $this) {
                $chat->setConversation(null);
            }
        }

        return $this;
    }
}
