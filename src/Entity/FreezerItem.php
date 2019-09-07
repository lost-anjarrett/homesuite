<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FreezerItemRepository")
 */
class FreezerItem
{
    const UNITS = [
        'persons',
        'grams',
        'milliliters',
        'percents',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FreezerItemCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=11)
     * @Assert\Choice(choices=FreezerItem::UNITS, message="Choose a valid unit.")
     */
    private $unit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateExpiry;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Freezer", inversedBy="items")
     * @ORM\JoinColumn(nullable=true)
     */
    private $freezer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRemoval;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?FreezerItemCategory
    {
        return $this->category;
    }

    public function setCategory(?FreezerItemCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getDateExpiry(): ?\DateTimeInterface
    {
        return $this->dateExpiry;
    }

    public function setDateExpiry(\DateTimeInterface $dateExpiry): self
    {
        $this->dateExpiry = $dateExpiry;

        return $this;
    }

    public function getFreezer(): ?Freezer
    {
        return $this->freezer;
    }

    public function setFreezer(?Freezer $freezer): self
    {
        $this->freezer = $freezer;

        return $this;
    }

    public function getDateRemoval(): ?\DateTimeInterface
    {
        return $this->dateRemoval;
    }

    public function setDateRemoval(?\DateTimeInterface $dateRemoval): self
    {
        $this->dateRemoval = $dateRemoval;

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

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
