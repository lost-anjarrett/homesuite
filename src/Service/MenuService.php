<?php


namespace App\Service;


class MenuService
{
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
            $nextDays[] = new \DateTime('now + '.$i.' day');
        }

        return $nextDays;
    }
}