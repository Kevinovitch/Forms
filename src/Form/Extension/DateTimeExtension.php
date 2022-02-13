<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class DateTimeExtension extends AbstractTypeExtension
{

    /**
     * @return iterable|string[]
     */
    public static function getExtendedTypes(): iterable
    {
        return [DateTimeType::class, DateType::class, TimeType::class];
    }
}