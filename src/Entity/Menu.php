<?php

namespace App\Entity;

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
}
