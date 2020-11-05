<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Util;

final class StringUtils
{
    public static function obfuscate(string $string, int $start = 0, int $end = 3, string $replacement = '*'): string
    {
        $length = \strlen($string);

        if ($start < 0) {
            $start += $length;
        }
        $start = min($start, $length - 1);

        if ($end < 0) {
            $end += $length;
        }
        $end = min($end, $length - 1);

        if (self::verifyLength($length, $start, $end)) {
            return $string;
        }

        return substr($string, 0, $start).
            str_repeat($replacement, $length - $end - $start).
            substr($string, $length - $end, $end);
    }

    private static function verifyLength(int $length, int $startPosition, int $endPosition): bool
    {
        return 0    === $length               ||
            $length === $startPosition + 1    ||
            $length === $endPosition   + 1    ||
            $length <= $startPosition  + $endPosition;
    }
}
