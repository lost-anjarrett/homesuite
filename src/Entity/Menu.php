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

    /**
     * Menu constructor.
     */
    public function __construct()
    {
        $this->days = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return House|null
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * @param House $house
     *
     * @return Menu
     */
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

    /**
     * @param Day $day
     */
    public function addDay(Day $day)
    {
        $this->days->add($day);
    }
}
