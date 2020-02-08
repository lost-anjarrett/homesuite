<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FreezerItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class FreezerItem
{
    use DefaultDatetimeTrait;

    const UNITS = [
        'persons' => 'persons',
        'grams' => 'grams',
        'milliliters' => 'milliliters',
        'percents' => 'percents',
        'units' => 'units',
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
     * @var FreezerItemCategory
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
     * @var \DateTime $dateExpiry
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return FreezerItemCategory|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param FreezerItemCategory|null $category
     *
     * @return FreezerItem
     */
    public function setCategory(FreezerItemCategory $category = null): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return FreezerItem
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return FreezerItem
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     *
     * @return FreezerItem
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateExpiry()
    {
        return $this->dateExpiry;
    }

    /**
     * @param \DateTimeInterface $dateExpiry
     *
     * @return FreezerItem
     */
    public function setDateExpiry(\DateTimeInterface $dateExpiry): self
    {
        $this->dateExpiry = $dateExpiry;

        return $this;
    }

    /**
     * @return Freezer|null
     */
    public function getFreezer()
    {
        return $this->freezer;
    }

    /**
     * @param Freezer|null $freezer
     *
     * @return FreezerItem
     */
    public function setFreezer(Freezer $freezer = null): self
    {
        $this->freezer = $freezer;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateRemoval()
    {
        return $this->dateRemoval;
    }

    /**
     * @param \DateTimeInterface|null $dateRemoval
     *
     * @return FreezerItem
     */
    public function setDateRemoval(\DateTimeInterface $dateRemoval = null): self
    {
        $this->dateRemoval = $dateRemoval;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User|null $creator
     *
     * @return FreezerItem
     */
    public function setCreator(User $creator = null): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function expiresSoon()
    {
        if ($this->category->getDefaultValidity() <= 30) {
            $soon = 7;
        } elseif ($this->category->getDefaultValidity() <= 60) {
            $soon = 15;
        } else {
            $soon = 30;
        }

        return (0 < $this->dateExpiry->getTimestamp() - time()
            && $this->dateExpiry->getTimestamp() - time() < ($soon * 24 * 60 * 60)
        );
    }

    public function hasExpired()
    {
        return (0 >= $this->dateExpiry->getTimestamp() - time());
    }
}
