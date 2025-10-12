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
    private const MAIL_HTML_PATTERN = '/\<a(?:[^>]+)href\=\"mailto\:([^">]+)\"(?:[^>]*)\>(.*?)\<\/a\>/ism';
    private const MAIL_TEXT_PATTERN = '/(([A-Z0-9._%+-]+)@([A-Z0-9.-]+)\.([A-Z]{2,4})(\((.+?)\))?)/i';

    /**
     * @var string[]
     */
    private readonly array $mailAtText;

    /**
     * @var string[]
     */
    private readonly array $mailDotText;

    /**
     * @param string[] $mailAtText
     * @param string[] $mailDotText
     */
    public function __construct(array $mailAtText, array $mailDotText)
    {
        $this->mailAtText   = $mailAtText;
        $this->mailDotText  = $mailDotText;
    }

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

        return \sprintf('%s %sB', $formatter->format($number, NumberFormatter::TYPE_DEFAULT), $prefix);
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

    /**
     * Replaces email addresses with an alternative text representation.
     *
     * @param string $text   input string
     * @param bool   $isHtml Secure html or text
     *
     * @return string with replaced links
     */
    public function spamsecure(string $text, bool $isHtml = true): string
    {
        if ($isHtml) {
            return preg_replace_callback(self::MAIL_HTML_PATTERN, [$this, 'encryptMailHtml'], $text) ?? '';
        }

        return preg_replace_callback(self::MAIL_TEXT_PATTERN, [$this, 'encryptMailText'], $text) ?? '';
    }

    /**
     * @param string[] $matches
     */
    private function encryptMailHtml(array $matches): string
    {
        [$original, $email, $text] = $matches;

        if ($text === $email) {
            return \sprintf(
                '%s%s%s',
                $this->createSecuredName($email),
                $this->hashedArrayValue($this->mailAtText, $original),
                $this->createSecuredName($email, true)
            );
        }

        return \sprintf(
            '%s%s%s (%s)',
            $this->createSecuredName($email),
            $this->hashedArrayValue($this->mailAtText, $original),
            $this->createSecuredName($email, true),
            $text
        );
    }

    /**
     * @param string[] $matches
     */
    private function encryptMailText(array $matches): string
    {
        [$original, $email] = $matches;

        return $this->createSecuredName($email)
            .$this->hashedArrayValue($this->mailAtText, $original)
            .$this->createSecuredName($email, true);
    }

    private function createSecuredName(string $name, bool $isDomain = false): string
    {
        $index = strpos($name, '@');

        \assert(false !== $index);

        if ($isDomain) {
            $name = substr($name, $index + 1);
        } else {
            $name = substr($name, 0, $index);
        }

        return str_replace('.', $this->hashedArrayValue($this->mailDotText, $name), $name);
    }

    /**
     * @param string[] $list
     */
    private function hashedArrayValue(array $list, string $name): string
    {
        if ([] === $list) {
            return '';
        }

        $count = \count($list);

        $index = $this->numericHash($name) % $count;

        return $list[$index];
    }

    private function numericHash(string $name): int
    {
        $hash = hash('sha256', $name);

        return \intval(substr($hash, 0, 6), 16);
    }

    private function getPrefix(bool $si, int $exp): string
    {
        $prefixes = ($si ? 'kMGTPE' : 'KMGTPE');

        return $prefixes[$exp - 1].($si ? '' : 'i');
    }
}
