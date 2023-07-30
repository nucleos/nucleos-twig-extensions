<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Runtime;

use Locale;
use Nucleos\Twig\Util\StringUtils;
use NumberFormatter;
use Twig\Extension\RuntimeExtensionInterface;

final class StringRuntime implements RuntimeExtensionInterface
{
    public function formatBytes(float $bytes, bool $si = true, int $fractionDigits = 0, ?string $locale = null): string
    {
        if (null === $locale) {
            $locale = Locale::getDefault();
        }

        $unit = $si ? 1000 : 1024;

        if ($bytes < $unit) {
            $prefix = '';
            $number = $bytes;
        } else {
            $exp    = (int) (log($bytes) / log($unit));
            $prefix = $this->getPrefix($si, $exp);

            $number = $bytes / ($unit ** $exp);
        }

        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $fractionDigits);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $fractionDigits);

        return sprintf('%s %sB', $formatter->format($number, NumberFormatter::TYPE_DEFAULT), $prefix);
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

    private function getPrefix(bool $si, int $exp): string
    {
        $prefixes = ($si ? 'kMGTPE' : 'KMGTPE');

        return $prefixes[$exp - 1].($si ? '' : 'i');
    }
}
