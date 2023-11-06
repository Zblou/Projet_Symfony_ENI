<?php

namespace App\Form\Models;

use App\Entity\Campus;

class FilterModel
{
    public Campus $campus;
    public string $contains;
    public \DateTimeImmutable $dateStartTime;
    public \DateTimeImmutable $dateEndTime;
    public bool $isOrganizer;
    public bool $isRegisteredTo;
    public bool $isNotRegisteredTo;
    public bool $isPassed;

    public function getCampus(): Campus
    {
        return $this->campus;
    }

    public function setCampus(Campus $campus): FilterModel
    {
        $this->campus = $campus;
        return $this;
    }

    public function getContains(): string
    {
        return $this->contains;
    }

    public function setContains(string $contains): FilterModel
    {
        $this->contains = $contains;
        return $this;
    }

    public function getDateStartTime(): \DateTimeImmutable
    {
        return $this->dateStartTime;
    }

    public function setDateStartTime(\DateTimeImmutable $dateStartTime): FilterModel
    {
        $this->dateStartTime = $dateStartTime;
        return $this;
    }

    public function getDateEndTime(): \DateTimeImmutable
    {
        return $this->dateEndTime;
    }

    public function setDateEndTime(\DateTimeImmutable $dateEndTime): FilterModel
    {
        $this->dateEndTime = $dateEndTime;
        return $this;
    }

    public function isOrganizer(): bool
    {
        return $this->isOrganizer;
    }

    public function setIsOrganizer(bool $isOrganizer): FilterModel
    {
        $this->isOrganizer = $isOrganizer;
        return $this;
    }

    public function isRegisteredTo(): bool
    {
        return $this->isRegisteredTo;
    }

    public function setIsRegisteredTo(bool $isRegisteredTo): FilterModel
    {
        $this->isRegisteredTo = $isRegisteredTo;
        return $this;
    }

    public function isNotRegisteredTo(): bool
    {
        return $this->isNotRegisteredTo;
    }

    public function setIsNotRegisteredTo(bool $isNotRegisteredTo): FilterModel
    {
        $this->isNotRegisteredTo = $isNotRegisteredTo;
        return $this;
    }

    public function isPassed(): bool
    {
        return $this->isPassed;
    }

    public function setIsPassed(bool $isPassed): FilterModel
    {
        $this->isPassed = $isPassed;
        return $this;
    }


}