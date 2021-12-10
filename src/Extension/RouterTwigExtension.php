<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Twig\Extension;

use Sonata\DatagridBundle\Pager\PagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterTwigExtension extends AbstractExtension
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array<string, int|string>
     */
    private $options;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @param array<string, int|string> $options
     *
     * @throws LoaderError
     */
    public function __construct(Environment $environment, RouterInterface $router, array $options = [])
    {
        $this->environment = $environment;
        $this->router      = $router;
        $this->options     = $options;

        if (!isset($this->options['template'])) {
            throw new LoaderError('Pager template is not set.');
        }
        if (!isset($this->options['extremeLimit'])) {
            throw new LoaderError('Pager extreme limit is not set.');
        }
        if (!isset($this->options['nearbyLimit'])) {
            throw new LoaderError('Pager nearby limit is not set.');
        }
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('routeExists', [$this, 'routeExists']),
            new TwigFunction('page_pager', [$this, 'generatePager'], [
                'is_safe' => ['html'],
            ]),
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

    /**
     * @param array<string, int|string> $options
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generatePager(PagerInterface $pager, array $options = []): string
    {
        $data = array_merge(array_merge($this->options, $options), [
            'itemsCount'  => $pager->count(),
            'limit'       => max(1, $pager->getMaxPerPage()),
            'currentPage' => $pager->getPage(),
        ]);

        $data['lastPage'] = self::getNumPages((int) $data['limit'], (int) $data['itemsCount']);

        return $this->environment->render((string) $data['template'], $data);
    }

    private static function getNumPages(int $limit, int $count): int
    {
        return (int) ceil($count / $limit);
    }
}
