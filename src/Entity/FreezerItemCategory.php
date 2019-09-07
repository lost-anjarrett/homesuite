<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FreezerItemCategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class FreezerItemCategory
{
    use DefaultDatetimeTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $defaultValidity;

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

    public function getDefaultValidity(): ?int
    {
        return $this->defaultValidity;
    }

    public function setDefaultValidity(int $defaultValidity): self
    {
        $this->defaultValidity = $defaultValidity;

        return $this;
    }
}
