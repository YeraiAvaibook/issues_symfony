<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class DateRuntime implements RuntimeExtensionInterface
{
    public function formatDate($date)
    {
        return $date->format('d-m-Y H:i:s');
    }
}