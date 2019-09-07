<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait DatabaseDatesTrait
 *
 * Provides date fields to manage database : insert and update date. Both are automatically filled with
 * Doctrine ORM's PrePersist and PreUpdate methods.
 *
 * @package App\Traits
 */
trait DefaultDatetimeTrait
{
    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $dateCreation;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $dateUpdate;

    /**
     * @return \DateTime
     */
    public function getInsertDate(): \DateTime
    {
        return $this->dateCreation;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setInsertDate(): self
    {
        $this->dateCreation = new \DateTime();

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateDate(): \DateTime
    {
        return $this->dateUpdate;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function setUpdateDate(): self
    {
        $this->dateUpdate = new \DateTime();

        return $this;
    }
}
