<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Extension;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterTwigExtension extends AbstractExtension
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('routeExists', [$this, 'routeExists']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('splitTag', [$this, 'splitTag']),
        ];
    }

    public function routeExists(string $name): bool
    {
        return null !== $this->router->getRouteCollection()->get($name);
    }

    /**
     * @return string[]
     */
    public function splitTag(string $text, string $tag): array
    {
        if ('' === trim($tag)) {
            return [$text];
        }

        $split = preg_split('/(?=<'.$tag.'([^>])*>)/', $text, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        if (false !== $split) {
            return $split;
        }

        return [$text];
    }
}
