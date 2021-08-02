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

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="meals")
     */
    protected $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $creator;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=2100, nullable=true)
     * @Assert\Url(message="url is not valid")
     */
    private $recipeUrl;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return Meal
     */
    public function setDescription(string $description = null): self
    {
        $this->description = $description;

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
     * @return Meal
     */
    public function setCreator(User $creator = null): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Day|null
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param Day|null $day
     *
     * @return Meal
     */
    public function setDay(Day $day = null): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes(string $notes = null): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getRecipeUrl()
    {
        return $this->recipeUrl;
    }

    public function setRecipeUrl(string $recipeUrl = null): self
    {
        $this->recipeUrl = $recipeUrl;

        return $this;
    }
}
