<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DinnerRepository")
 *
 * @package App\Entity
 */
class Dinner extends Meal
{
    public function getType(): string
    {
        return 'dinner';
    }
}
