<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"breakfast" = "Breakfast", "lunch" = "Lunch", "dinner" = "Dinner"})
 *
 * @UniqueEntity(
 *     fields={"day", "type"},
 *     errorPath="type",
 *     message="A meal of this type is already planned for this day."
 * )
 */
abstract class Meal
{
    use DefaultDatetimeTrait;

    const TYPES = ['breakfast', 'lunch', 'dinner'];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="meals")
     */
    protected $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $creator;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;
}
