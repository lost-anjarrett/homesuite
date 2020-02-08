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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return FreezerItemCategory
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * in days
     * @return int|null
     */
    public function getDefaultValidity()
    {
        return $this->defaultValidity;
    }

    /**
     * @param int $defaultValidity
     *
     * @return FreezerItemCategory
     */
    public function setDefaultValidity(int $defaultValidity): self
    {
        $this->defaultValidity = $defaultValidity;

        return $this;
    }
}
