<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Extension;

use Nucleos\Twig\Runtime\UrlAutoConverterRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class UrlAutoConverterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('converturls', [UrlAutoConverterRuntime::class, 'convertLinks'], ['is_safe' => ['html']]),
        ];
    }
}
