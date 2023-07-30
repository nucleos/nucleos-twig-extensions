<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Extension;

use Nucleos\Twig\Runtime\StringRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class StringExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_bytes', [StringRuntime::class, 'formatBytes']),
            new TwigFilter('obfuscate', [StringRuntime::class, 'obfuscate']),
        ];
    }
}
