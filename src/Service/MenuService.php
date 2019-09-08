<?php


namespace App\Service;


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
    public function getComingMenuDays(Menu $menu, int $days)
    {
        $comingMenuDays = [];

        $nextDays = $this->getNextDays($days);
        $comingMeals = $this->mealRepository
            ->getComingMealDates($menu, new \DateTime('today'), new \DateInterval('P'.$days.'D'))
        ;

        foreach ($nextDays as $nextDay) {
            $hasPlannedMeal = in_array($nextDay->format('Y-m-d H:i:s'), $comingMeals);
            $comingMenuDays[] = new ComingMenuDay($nextDay, $hasPlannedMeal);
        }

        return $comingMenuDays;
    }

    public function getDayMeals(Menu $menu, \DateTime $date)
    {
        $results = $this->mealRepository->findBy(['menu' => $menu, 'date' => $date]);

        if (count($results) > 3) {
            throw new \LogicException('It can only be 3 meals a day, '.count($results).' were found for menu '.$menu->getId());
        }

        /**
         * @var int $key
         * @var Meal $meal
         */
        foreach ($results as $key => $meal) {
            $results[$meal->getType()] = $meal;
            unset($results[$key]);
        }

        return $results;
    }
}