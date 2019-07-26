<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\Twig\Bridge\Symfony\Bundle;

use Core23\Twig\Bridge\Symfony\DependencyInjection\Core23TwigExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class Core23TwigBundle extends Bundle
{
    public function getPath()
    {
        return __DIR__.'/..';
    }

    protected function getContainerExtensionClass()
    {
        return Core23TwigExtension::class;
    }
}
