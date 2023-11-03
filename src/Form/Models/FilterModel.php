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
}