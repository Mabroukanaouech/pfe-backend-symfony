<?php

namespace App\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\CategoryRepository")
 */
class Category
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Doctrine\Entity\Publicity", mappedBy="category")
     */
    private $publicities;

    public function __construct()
    {
        $this->publicities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Publicity[]
     */
    public function getPublicities(): Collection
    {
        return $this->publicities;
    }

    public function addPublicity(Publicity $publicity): self
    {
        if (!$this->publicities->contains($publicity)) {
            $this->publicities[] = $publicity;
            $publicity->setCategory($this);
        }

        return $this;
    }

    public function removePublicity(Publicity $publicity): self
    {
        if ($this->publicities->contains($publicity)) {
            $this->publicities->removeElement($publicity);
            // set the owning side to null (unless already changed)
            if ($publicity->getCategory() === $this) {
                $publicity->setCategory(null);
            }
        }

        return $this;
    }
}
