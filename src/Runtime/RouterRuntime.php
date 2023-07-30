<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Runtime;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class RouterRuntime implements RuntimeExtensionInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
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
