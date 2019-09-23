<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DayRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity(
 *     fields={"date", "menu"},
 *     errorPath="date",
 *     message="Cannot plan same day multiple times"
 * )
 */
class Day
{
    use DefaultDatetimeTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu")
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Meal", mappedBy="day", cascade={"persist", "remove"})
     */
    private $meals;

    public function __construct()
    {
        $this->meals = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Menu|null
     */
    public function getMenu()
    {
        return $this->menu;
    }

    public function setMenu(Menu $menu = null): self
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @return Collection|Meal[]
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meal $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals[] = $meal;
            $meal->setDay($this);
        }

        return $this;
    }

    public function removeMeal(Meal $meal): self
    {
        if ($this->meals->contains($meal)) {
            $this->meals->removeElement($meal);
            // set the owning side to null (unless already changed)
            if ($meal->getDay() === $this) {
                $meal->setDay(null);
            }
        }

        return $this;
    }
}
