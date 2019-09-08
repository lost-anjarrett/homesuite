<?php


namespace App\ValueObject;


class ComingMenuDay
{
    /** @var string $dateFormatted */
    private $dateFormatted;
    /** @var string $dayOfWeek */
    private $dayOfWeek;
    /** @var bool $mealPlanned */
    private $mealPlanned;

    /**
     * ComingMenuDay constructor.
     *
     * @param \DateTime $date
     * @param bool $mealPlanned
     */
    public function __construct(\DateTime $date, bool $mealPlanned = false)
    {
        $this->dateFormatted = $date->format('Ymd');
        $this->dayOfWeek = $date->format('l');
        $this->mealPlanned = $mealPlanned;
    }

    /**
     * @return string
     */
    public function getDateFormatted(): string
    {
        return $this->dateFormatted;
    }

    /**
     * @return string
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @return bool
     */
    public function isMealPlanned(): bool
    {
        return $this->mealPlanned;
    }
}
