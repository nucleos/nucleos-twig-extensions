<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\TwigExtensions\Twig\Extension;

use Sonata\DatagridBundle\Pager\BasePager;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Extension\AbstractExtension;
use Twig\Extension\InitRuntimeInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class RouterTwigExtension extends AbstractExtension implements InitRuntimeInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @param RouterInterface $router
     * @param array           $options
     *
     * @throws LoaderError
     */
    public function __construct(RouterInterface $router, array $options = [])
    {
        $this->router  = $router;
        $this->options = $options;

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

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment): void
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('routeExists', [$this, 'routeExists']),
            new TwigFunction('page_pager', [$this, 'generatePager'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('splitTag', [$this, 'splitTag']),
        ];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function routeExists(string $name): bool
    {
        return null !== $this->router->getRouteCollection()->get($name);
    }

    /**
     * @param string $text
     * @param string $tag
     *
     * @return string[]
     */
    public function splitTag(string $text, string $tag): array
    {
        if (!$tag) {
            return [$text];
        }

        return preg_split('/(?=<'.$tag.'([^>])*>)/', $text, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    }

    /**
     * @param BasePager $pager
     * @param array     $options
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function generatePager(BasePager $pager, array $options = []): string
    {
        $data = array_merge(array_merge($this->options, $options), [
            'itemsCount'  => $pager->count(),
            'limit'       => $pager->getMaxPerPage(),
            'currentPage' => $pager->getPage(),
        ]);

        $data['lastPage'] = $this->getNumPages((int) $data['limit'], (int) $data['itemsCount']);

        return $this->environment->render($data['template'], $data);
    }

    /**
     * @param int $limit
     * @param int $count
     *
     * @return int
     */
    protected function getNumPages(int $limit, int $count): int
    {
        if ($limit < 1) {
            return 1;
        }

        return (int) ceil($count / $limit);
    }
}
