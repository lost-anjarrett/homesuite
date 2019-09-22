<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LunchRepository")
 *
 * @package App\Entity
 */
class Lunch extends Meal
{
    public function getType(): string
    {
        return 'lunch';
    }
}
