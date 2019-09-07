<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HouseRepository")
 */
class House
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Menu", mappedBy="house", cascade={"persist", "remove"})
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Freezer", mappedBy="house")
     */
    private $freezers;

    public function __construct()
    {
        $this->freezers = new ArrayCollection();
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(Menu $menu): self
    {
        $this->menu = $menu;

        // set the owning side of the relation if necessary
        if ($this !== $menu->getHouse()) {
            $menu->setHouse($this);
        }

        return $this;
    }

    /**
     * @return Collection|Freezer[]
     */
    public function getFreezers(): Collection
    {
        return $this->freezers;
    }

    public function addFreezer(Freezer $freezer): self
    {
        if (!$this->freezers->contains($freezer)) {
            $this->freezers[] = $freezer;
            $freezer->setHouse($this);
        }

        return $this;
    }

    public function removeFreezer(Freezer $freezer): self
    {
        if ($this->freezers->contains($freezer)) {
            $this->freezers->removeElement($freezer);
            // set the owning side to null (unless already changed)
            if ($freezer->getHouse() === $this) {
                $freezer->setHouse(null);
            }
        }

        return $this;
    }
}
