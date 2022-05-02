<?php

namespace Gupalo\BpmnWorkflowBundle\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gupalo\BpmnWorkflowBundle\Repository\ProcessRepository;
use Gupalo\BpmnWorkflowBundle\Validator\BpmnConstraint as AssertBpmn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProcessRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'unique_slug', columns: ['slug'])]
#[UniqueEntity('slug')]
class Process
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Field xml can not be empty')]
    #[Assert\NotNull(message: 'Field xml can not be empty')]
    #[AssertBpmn()]
    private string $xml;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank(message: 'Field name can not be empty')]
    #[Assert\NotNull(message: 'Field name can not be empty')]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank(message: 'Field slug can not be empty')]
    #[Assert\NotNull(message: 'Field slug can not be empty')]
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
        $this->initializeCreatedAt();

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
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function initializeCreatedAt(): void
    {
        if (!isset($this->createdAt)) {
            $this->createdAt = new DateTimeImmutable();
        }
    }
}
