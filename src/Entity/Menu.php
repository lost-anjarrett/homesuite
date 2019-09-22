<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Menu
{
    use DefaultDatetimeTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\House", inversedBy="menu", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $house;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Day", mappedBy="menu")
     */
    private $days;

    public function __construct()
    {
        $this->days = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(House $house): self
    {
        $this->house = $house;

        return $this;
    }

    /**
     * @return Collection|Day[]
     * @throws \Exception
     */
    public function getPlannedDays(): Collection
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->gte('date', new \DateTime('today')));

        return $this->days->matching($criteria);
    }

    public function addDay(Day $day)
    {
        $this->days->add($day);
    }
}
