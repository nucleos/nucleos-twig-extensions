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
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('converturls', [$this, 'convertLinks'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @param string $text
     * @param array  $options
     *
     * @return string
     */
    public function convertLinks(string $text, array $options = []): string
    {
        // https://bitbucket.org/kwi/urllinker/
        $text = (string) preg_replace('#(script|about|applet|activex|chrome):#is', '\\1:', $text);
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
}
