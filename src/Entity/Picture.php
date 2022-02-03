<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Interface\TimestampableInterface;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture implements IdentifiableInterface, TimestampableInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(name: 'author_name', type: 'string', length: 255)]
    protected ?string $authorName = null;

    #[Assert\Url]
    #[Assert\Length(max: 255)]
    #[ORM\Column(name: 'author_profile', type: 'string', length: 255, nullable: true)]
    protected ?string $authorProfile = null;

    /**
     * @var array<int>|null
     */
    #[ORM\Column(name: 'dimensions', type: 'array', nullable: true)]
    protected ?array $dimensions = null;

    #[Assert\Expression(expression: 'this.getFile() !== null || this.getFileName() !== null')]
    #[Assert\Image(maxSize: '5Mi', mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        maxWidth: 3000, maxHeight: 2000)]
    #[Vich\UploadableField(mapping: 'picture', fileNameProperty: 'fileName', size: 'size', mimeType: 'mimeType',
        originalName: 'originalName', dimensions: 'dimensions')]
    protected ?File $file = null;

    #[ORM\Column(name: 'fileName', type: 'string', length: 255, nullable: true)]
    protected ?string $fileName = null;

    #[Assert\NotBlank]
    #[ORM\Column(name: 'license', type: 'string', length: 255)]
    protected ?string $license = null;

    #[ORM\Column(name: 'mime_type', type: 'string', length: 255, nullable: true)]
    protected ?string $mimeType = null;

    #[ORM\Column(name: 'original_name', type: 'string', length: 255, nullable: true)]
    protected ?string $originalName = null;

    #[ORM\Column(name: 'size', type: 'integer', nullable: true)]
    protected ?int $size = null;

    #[Assert\NotBlank]
    #[Assert\Url]
    #[Assert\Length(max: 255)]
    #[ORM\Column(name: 'source', type: 'string', length: 255)]
    protected ?string $source = null;

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): Picture
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getAuthorProfile(): ?string
    {
        return $this->authorProfile;
    }

    public function setAuthorProfile(?string $authorProfile): Picture
    {
        $this->authorProfile = $authorProfile;
        return $this;
    }

    /**
     * @return array<int>|null
     */
    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    /**
     * @param array<int>|null $dimensions
     */
    public function setDimensions(?array $dimensions): Picture
    {
        $this->dimensions = $dimensions;
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): Picture
    {
        $this->file = $file;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): Picture
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(?string $license): Picture
    {
        $this->license = $license;
        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): Picture
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): Picture
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): Picture
    {
        $this->size = $size;
        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): Picture
    {
        $this->source = $source;
        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->fileName;
    }
}
