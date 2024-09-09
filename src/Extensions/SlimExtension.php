<?php

namespace App\Extensions;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SlimExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('currency', fn ($value) => number_format($value) . ' Cr'),
            new TwigFilter('number', fn ($value, int $decimals = 0) => number_format($value, $decimals)),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('currentUrl', [SlimRuntimeExtension::class, 'getCurrentUrl']),
            new TwigFunction('fullUrlFor', [SlimRuntimeExtension::class, 'fullUrlFor']),
            new TwigFunction('isCurrentUrl', [SlimRuntimeExtension::class, 'isCurrentUrl']),
            new TwigFunction('urlFor', [SlimRuntimeExtension::class, 'urlFor']),

            new TwigFunction('time', [$this, 'time']),
        ];
    }

    public function time(string $dateTime): string
    {
        return CarbonImmutable::parse($dateTime)
            ->diffForHumans(null, CarbonInterface::DIFF_ABSOLUTE, false, 2);
    }
}
