<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Twig\Extension;

use Core23\TwigExtensions\Util\StringUtils;
use Sonata\IntlBundle\Templating\Helper\NumberHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class StringTwigExtension extends AbstractExtension
{
    /**
     * @var NumberHelper
     */
    private $numberHelper;

    /**
     * StringTwigExtension constructor.
     *
     * @param NumberHelper $numberHelper
     */
    public function __construct(NumberHelper $numberHelper)
    {
        $this->numberHelper = $numberHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('format_bytes', [$this, 'formatBytes']),
            new TwigFilter('obfuscate', [$this, 'obfuscate']),
        ];
    }

    /**
     * @param float $bytes
     * @param bool  $si
     * @param int   $fractionDigits
     *
     * @return string
     */
    public function formatBytes(float $bytes, bool $si = true, int $fractionDigits = 0): string
    {
        $unit = $si ? 1000 : 1024;

        if ($bytes < $unit) {
            $pre = 'B';
            $num = $bytes;
        } else {
            $exp = (int) (log($bytes) / log($unit));
            $pre = ($si ? 'kMGTPE' : 'KMGTPE');
            $pre = $pre[$exp - 1].($si ? '' : 'i');

            $num = $bytes / ($unit ** $exp);
        }

        return sprintf('%s %sB', $this->numberHelper->formatDecimal($num, [
            'fraction_digits' => $fractionDigits,
        ]), $pre);
    }

    /**
     * @param string $string
     * @param array  $options
     *
     * @return string
     */
    public function obfuscate(string $string, array $options = []): string
    {
        $options = array_merge([
            'start'       => 0,
            'end'         => 3,
            'replacement' => '*',
        ], $options);

        return StringUtils::obfuscate($string, $options['start'], $options['end'], $options['replacement']);
    }
}
