<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HouseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class House
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Menu", mappedBy="house", cascade={"persist", "remove"})
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Freezer", mappedBy="house")
     */
    private $freezers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="house")
     */
    private $habitants;

    public function __construct()
    {
        $this->freezers = new ArrayCollection();
        $this->habitants = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getHabitants(): Collection
    {
        return $this->habitants;
    }

    public function addHabitant(User $habitant): self
    {
        if (!$this->habitants->contains($habitant)) {
            $this->habitants[] = $habitant;
            $habitant->setHouse($this);
        }

        return $this;
    }

    public function removeHabitant(User $habitant): self
    {
        if ($this->habitants->contains($habitant)) {
            $this->habitants->removeElement($habitant);
            // set the owning side to null (unless already changed)
            if ($habitant->getHouse() === $this) {
                $habitant->setHouse(null);
            }
        }

        return $this;
    }
}
