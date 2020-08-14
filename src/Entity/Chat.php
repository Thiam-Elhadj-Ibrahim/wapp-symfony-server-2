<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\ResourceEntity;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ApiResource(
 *     paginationMaximumItemsPerPage=20,
 *     normalizationContext={
 *         "groups"={
 *             "chat:read"
 *         }
 *     },
 *     denormalizationContext={
 *         "groups"={
 *             "chat:write"
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
class Chat
{
    use ResourceEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"chat:read", "conversation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"chat:read", "chat:write", "conversation:read", "conversation:write"})
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"chat:read", "chat:write", "conversation:read", "conversation:write"})
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"chat:read", "chat:write", "conversation:read", "conversation:write"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Conversation::class, inversedBy="chats")
     */
    private $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }
}
