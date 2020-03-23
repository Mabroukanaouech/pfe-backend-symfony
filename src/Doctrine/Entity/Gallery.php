<?php

namespace App\Doctrine\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\GalleryRepository")
 *@Vich\Uploadable
 */
class Gallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="publicity_gallery", fileNameProperty="image")
     * @var File
     */
    private $galleryFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Doctrine\Entity\Publicity", inversedBy="gallery")
     */
    private $publicity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGalleryFile(): ?string
    {
        return $this->galleryFile;
    }

    public function setGalleryFile(string $galleryFile): self
    {
        $this->galleryFile = $galleryFile;

        return $this;
    }

    public function getPublicity(): ?Publicity
    {
        return $this->publicity;
    }

    public function setPublicity(?Publicity $publicity): self
    {
        $this->publicity = $publicity;

        return $this;
    }
}
