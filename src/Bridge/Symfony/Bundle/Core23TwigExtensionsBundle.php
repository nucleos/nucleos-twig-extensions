<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Bridge\Symfony\Bundle;

use Core23\TwigExtensions\Bridge\Symfony\DependencyInjection\Core23TwigExtensionsExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class Core23TwigExtensionsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return __DIR__.'/..';
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensionClass()
    {
        return Core23TwigExtensionsExtension::class;
    }
}
