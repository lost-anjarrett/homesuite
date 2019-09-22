<?php


namespace App\Service;


use App\Entity\Breakfast;
use App\Entity\Day;
use App\Entity\Dinner;
use App\Entity\Lunch;
use App\Entity\Meal;
use App\Entity\Menu;
use App\Repository\MealRepository;
use App\ValueObject\ComingMenuDay;

class MenuService
{
    /**
     * @var MealRepository
     */
    private $mealRepository;

    public function __construct(MealRepository $repository)
    {
        $this->mealRepository = $repository;

    }

    /**
     * Returns the current day + the next {days} days
     *
     * @param int $days
     *
     * @return array
     * @throws \Exception
     */
    public function getNextDays(int $days)
    {
        $nextDays = [];
        for ($i=0; $i<=$days; $i++) {
            $nextDays[] = new \DateTime('today + '.$i.' day');
        }

        return $nextDays;
    }

    /**
     * @param Menu $menu
     * @param int $days
     *
     * @return ComingMenuDay[]
     * @throws \Exception
     */
    public function getComingMenuDays(Menu $menu, int $numberOfDays)
    {
        $comingMenuDays = [];

        $nextDays = $this->getNextDays($menu, $numberOfDays);

        return $comingMenuDays;
    }

    public function getDayMeals(Menu $menu, \DateTime $date)
    {
        $results = null;

        return $results;
    }

    public function getNewDay(Menu $menu, \DateTime $date)
    {
        $day = new Day();
        $day->setMenu($menu);
        $day->setDate($date);
        $breakfast = new Breakfast();
        $day->addMeal($breakfast);
        $lunch = new Lunch();
        $day->addMeal($lunch);
        $dinner = new Dinner();
        $day->addMeal($dinner);

        return $day;
    }
}