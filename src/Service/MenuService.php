<?php


namespace App\Service;


use App\Entity\Breakfast;
use App\Entity\Day;
use App\Entity\Dinner;
use App\Entity\Lunch;
use App\Entity\Menu;
use Doctrine\Common\Collections\Collection;

class MenuService
{
    public function getMenuDays(Menu $menu, \DateTime $startFrom)
    {
        $newDays = $this->fillPlanningWithNewDays($menu, $startFrom);

        return  $this->sortDays($newDays->getValues());
    }

    /**
     * Function will add empty days between already planned days (those with at least one meal registered)
     *
     * @return Day[]|Collection
     * @throws \Exception
     */
    private function fillPlanningWithNewDays(Menu $menu, \DateTime $startFrom)
    {
        $nextNewDays = $this->getNextWeek($menu, $startFrom);
        $plannedDays = $menu->getPlannedDays($startFrom);

        foreach ($nextNewDays as $nextNewDay) {
            if (!$this->isDayPlanned($nextNewDay, $plannedDays)) {
                $plannedDays->add($nextNewDay);
            }
        }

        return $plannedDays;
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
    private function getNextWeek(Menu $menu, \DateTime $startFrom): array
    {
        $nextDays = [];
        for ($i = 0; $i <= 7; $i++) {
            $date = clone $startFrom;
            $nextDays[] = $this->getNewDay($menu, $date->add(new \DateInterval('P'.$i.'D')));
        }

        return $nextDays;
    }

    private function getNewDay(Menu $menu, \DateTime $date)
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

    private function isDayPlanned(Day $day, Collection $plannedDays)
    {
        return $plannedDays->exists(function ($key, Day $plannedDay) use ($day) {
            return $day->getDate() == $plannedDay->getDate();
        });
    }

    /**
     * @param array $days
     *
     * @return array
     */
    private function sortDays(array $days)
    {
        usort($days, function (Day $a, Day $b) {
            return $a->getDate()->getTimestamp() - $b->getDate()->getTimestamp();
        });
        return $days;
    }
}