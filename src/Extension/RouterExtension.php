<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Extension;

use Nucleos\Twig\Runtime\RouterRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('routeExists', [RouterRuntime::class, 'routeExists']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('splitTag', [RouterRuntime::class, 'splitTag']),
        ];
    }
}
