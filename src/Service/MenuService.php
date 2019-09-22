<?php


namespace App\Service;


use App\Entity\Breakfast;
use App\Entity\Day;
use App\Entity\Dinner;
use App\Entity\Lunch;
use App\Entity\Menu;
use App\Repository\MealRepository;
use App\ValueObject\ComingMenuDay;
use Doctrine\Common\Collections\Collection;

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
     * @param Menu $menu
     * @param int $numberOfDays
     *
     * @return array|Day[]
     * @throws \Exception
     */
    public function getNextNewDays(Menu $menu, int $numberOfDays): array
    {
        $nextDays = [];
        for ($i=0; $i<=$numberOfDays; $i++) {
            $nextDays[] = $this->getNewDay($menu, new \DateTime('today + '.$i.' day'));
        }

        return $nextDays;
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

    public function isDayPlanned(Day $day, Collection $plannedDays)
    {
        return $plannedDays->exists(function ($key, Day $plannedDay) use ($day) {
            return $day->getDate() == $plannedDay->getDate();
        });
    }

    public function fillPlanningWithNewDays(Menu $menu)
    {
        $nextNewDays = $this->getNextNewDays($menu, 7);
        $plannedDays = $menu->getPlannedDays();

        foreach ($nextNewDays as $nextNewDay) {
            if (!$this->isDayPlanned($nextNewDay, $plannedDays)) {
                $plannedDays->add($nextNewDay);
            }
        }

        // Fixme: have to find a way to sort by date, for now, persisted days are rendered first

        return $plannedDays;
    }
}