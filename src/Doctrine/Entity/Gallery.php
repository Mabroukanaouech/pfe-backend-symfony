<?php

namespace App\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\GalleryRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $galleryFile;

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
}
