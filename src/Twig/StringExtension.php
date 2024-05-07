<?php

// src/Twig/StringExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('string_slice', [$this, 'stringSlice']),
        ];
    }

    public function stringSlice($string, $start, $end)
    {
        return mb_substr($string, $start, $end);
    }
}