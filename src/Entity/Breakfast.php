<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BreakfastRepository")
 *
 * @package App\Entity
 */
class Breakfast extends Meal
{
    public function getType(): string
    {
        return 'breakfast';
    }
}
