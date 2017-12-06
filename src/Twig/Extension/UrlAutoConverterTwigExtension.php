<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class UrlAutoConverterTwigExtension extends AbstractExtension
{
    /**
     * @var bool
     */
    protected $secureMail;

    /**
     * @var string
     */
    protected $mailCssClass;

    /**
     * @var string
     */
    protected $mailAtText;

    /**
     * @var string
     */
    protected $mailDotText;

    /**
     * @param bool   $secureMail
     * @param string $mailDotText
     * @param string $mailCssClass
     * @param string $mailAtText
     */
    public function __construct(bool $secureMail, string $mailDotText, string $mailCssClass, string $mailAtText)
    {
        $this->secureMail   = $secureMail;
        $this->mailDotText  = $mailDotText;
        $this->mailCssClass = $mailCssClass;
        $this->mailAtText   = $mailAtText;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('converturls', [$this, 'autoConvertUrls'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * method that finds different occurrences of urls or email addresses in a string.
     *
     * @param string $string  input string
     * @param array  $options
     *
     * @return string with replaced links
     */
    public function autoConvertUrls(string $string, array $options = []): string
    {
        $string = $this->convertLinks($string, $options);

        if ($this->secureMail) {
            $pattern = '/\<a([^>]+)href\=\"mailto\:([^">]+)\"([^>]*)\>(.*?)\<\/a\>/ism';
            $string  = preg_replace_callback($pattern, [$this, 'encryptMail'], $string);
        }

        return $string;
    }

    /**
     * @param string $text
     * @param array  $options
     *
     * @return string
     */
    protected function convertLinks(string $text, array $options = []): string
    {
        // https://bitbucket.org/kwi/urllinker/
        $text = preg_replace('#(script|about|applet|activex|chrome):#is', '\\1:', $text);
        $ret  = ' '.$text;

        $attr = '';
        foreach ($options as $key => $value) {
            $attr .= ' '.$key.'="'.$value.'"';
        }

        // Replace Links with http://
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", '\\1<a href="\\2"'.$attr.'>\\2</a>', $ret);

        // Replace Links without http://
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", '\\1<a href="http://\\2"'.$attr.'>\\2</a>', $ret);

        // Replace Email Addresses
        $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", '\\1<a href="mailto:\\2@\\3"'.$attr.'>\\2@\\3</a>', $ret);

        return substr($ret, 1);
    }

    /**
     * @param string[] $matches
     *
     * @return string
     */
    protected function encryptMail(array $matches): string
    {
        [$part1, $part2, $email, $part4, $text] = $matches;

        if ($text === $email) {
            $text = '';
        }

        return '<span class="'.$this->mailCssClass.'">'.
        '<span>'.$this->getSecuredName($email).'</span>'.
        $this->mailAtText.
        '<span>'.$this->getSecuredName($email, true).'</span>'.
        ($text ? ' (<span>'.$text.'</span>)' : '').
        '</span>';
    }

    /**
     * @param string $name
     * @param bool   $isDomain
     *
     * @return string
     */
    protected function getSecuredName(string $name, bool $isDomain = false): string
    {
        $index = strpos($name, '@');

        if ($index === -1) {
            return '';
        }

        if ($isDomain) {
            $name = substr($name, $index + 1);
        } else {
            $name = substr($name, 0, $index);
        }

        return str_replace('.', $this->mailDotText, $name);
    }
}
