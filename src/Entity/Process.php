<?php

namespace Gupalo\BpmnWorkflowBundle\Entity;

use App\Repository\BranchRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gupalo\BpmnWorkflowBundle\Repository\ProcessRepository;

#[ORM\Entity(repositoryClass: ProcessRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'unique_slug', columns: ['slug'])]
class Process
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $xml;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private string $slug;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getXml(): string
    {
        return $this->xml;
    }
    
    public function setXml(string $xml): void
    {
        $this->xml = $xml;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function getSlug(): string
    {
        return $this->slug;
    }
    
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
    
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PreUpdate]
    public function refreshUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }

    #[ORM\PrePersist]
    public function initializeCreatedAt(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new DateTime();
        }
    }
}
