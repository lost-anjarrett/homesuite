<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FreezerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Freezer
{
    use DefaultDatetimeTrait;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\House", inversedBy="freezers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $house;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FreezerItem", mappedBy="freezer")
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): self
    {
        $this->house = $house;

        return $this;
    }

    /**
     * @return Collection|FreezerItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(FreezerItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setFreezer($this);
        }

        return $this;
    }

    public function removeItem(FreezerItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getFreezer() === $this) {
                $item->setFreezer(null);
            }
        }

        return $this;
    }
}
