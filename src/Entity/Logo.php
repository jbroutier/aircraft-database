<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\LogoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: LogoRepository::class)]
class Logo implements IdentifiableInterface, TimestampableInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[Assert\Expression(expression: 'this.getFile() !== null || this.getFileName() !== null')]
    #[Assert\Image(maxSize: '512Ki', mimeTypes: ['image/svg', 'image/svg+xml'])]
    #[Vich\UploadableField(mapping: 'logo', fileNameProperty: 'fileName', size: 'size', mimeType: 'mimeType',
        originalName: 'originalName')]
    protected ?File $file = null;

    #[ORM\Column(name: 'file_name', type: 'string', length: 255, nullable: true)]
    protected ?string $fileName = null;

    #[ORM\Column(name: 'mime_type', type: 'string', length: 255, nullable: true)]
    protected ?string $mimeType = null;

    #[ORM\Column(name: 'original_name', type: 'string', length: 255, nullable: true)]
    protected ?string $originalName = null;

    #[ORM\Column(name: 'size', type: 'integer', nullable: true)]
    protected ?int $size = null;

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): Logo
    {
        $this->file = $file;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): Logo
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): Logo
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): Logo
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): Logo
    {
        $this->size = $size;
        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->fileName;
    }
}
