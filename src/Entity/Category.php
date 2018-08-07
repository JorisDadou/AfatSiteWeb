<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Galerie", mappedBy="category")
     */
    private $galeries;

    public function __construct()
    {
        $this->galeries = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Galerie[]
     */
    public function getGaleries(): Collection
    {
        return $this->galeries;
    }

    public function addGalerie(Galerie $galerie): self
    {
        if (!$this->galeries->contains($galerie)) {
            $this->galeries[] = $galerie;
            $galerie->setCategory($this);
        }

        return $this;
    }

    public function removeGalerie(Galerie $galerie): self
    {
        if ($this->galeries->contains($galerie)) {
            $this->galeries->removeElement($galerie);
            // set the owning side to null (unless already changed)
            if ($galerie->getCategory() === $this) {
                $galerie->setCategory(null);
            }
        }

        return $this;
    }
}
