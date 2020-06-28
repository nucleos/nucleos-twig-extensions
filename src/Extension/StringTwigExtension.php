<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Extension;

use Locale;
use Nucleos\Twig\Util\StringUtils;
use NumberFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class StringTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('format_bytes', [$this, 'formatBytes']),
            new TwigFilter('obfuscate', [$this, 'obfuscate']),
        ];
    }

    public function formatBytes(float $bytes, bool $si = true, int $fractionDigits = 0, ?string $locale = null): string
    {
        if (null === $locale) {
            $locale = Locale::getDefault();
        }

        $unit = $si ? 1000 : 1024;

        if ($bytes < $unit) {
            $pre = '';
            $num = $bytes;
        } else {
            $exp = (int) (log($bytes) / log($unit));
            $pre = ($si ? 'kMGTPE' : 'KMGTPE');
            $pre = $pre[$exp - 1].($si ? '' : 'i');

            $num = $bytes / ($unit ** $exp);
        }

        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $fractionDigits);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $fractionDigits);

        return sprintf('%s %sB', $formatter->format($num, NumberFormatter::TYPE_DEFAULT), $pre);
    }

    /**
     * @param array<string, int|string> $options
     */
    public function obfuscate(string $string, array $options = []): string
    {
        $options = array_merge([
            'start'       => 0,
            'end'         => 3,
            'replacement' => '*',
        ], $options);

        return StringUtils::obfuscate($string, (int) $options['start'], (int) $options['end'], (string) $options['replacement']);
    }
}
