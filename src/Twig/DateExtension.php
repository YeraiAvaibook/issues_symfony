<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('dateFormat', [DateRuntime::class, 'formatDate'])
        ];
    }
}