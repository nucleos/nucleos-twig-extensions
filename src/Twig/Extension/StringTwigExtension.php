<?php

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
        return array(
            new TwigFilter('format_bytes', array($this, 'formatBytes')),
            new TwigFilter('obfuscate', array($this, 'obfuscate')),
        );
    }

    /**
     * @param int       $bytes
     * @param bool|true $si
     * @param int       $fractionDigits
     *
     * @return string
     */
    public function formatBytes(int $bytes, bool $si = true, int $fractionDigits = 0): string
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

        return sprintf('%s %sB', $this->numberHelper->formatDecimal($num, array(
            'fraction_digits' => $fractionDigits,
        )), $pre);
    }

    /**
     * @param string $string
     * @param array  $options
     *
     * @return string
     */
    public function obfuscate(string $string, array $options = array())
    {
        $options = array_merge(array(
            'start'       => 0,
            'end'         => 3,
            'replacement' => '*',
        ), $options);

        return StringUtils::obfuscate($string, $options['start'], $options['end'], $options['replacement']);
    }
}
