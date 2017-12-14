What is the Twig Extensions PHP library?
========================================
[![Latest Stable Version](https://poser.pugx.org/core23/twig-extensions/v/stable)](https://packagist.org/packages/core23/twig-extensions)
[![Latest Unstable Version](https://poser.pugx.org/core23/twig-extensions/v/unstable)](https://packagist.org/packages/core23/twig-extensions)
[![License](https://poser.pugx.org/core23/twig-extensions/license)](https://packagist.org/packages/core23/twig-extensions)

[![Build Status](https://travis-ci.org/core23/twig-extensions.svg)](http://travis-ci.org/core23/twig-extensions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/core23/twig-extensions/badges/quality-score.png)](https://scrutinizer-ci.com/g/core23/twig-extensions/)
[![Coverage Status](https://coveralls.io/repos/core23/twig-extensions/badge.svg)](https://coveralls.io/r/core23/twig-extensions)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2b7b70c7-98fd-4dcb-95ed-8d271f46eda6/mini.png)](https://insight.sensiolabs.com/projects/51aa4b42-d229-4994-bb3a-156da22a1375)

[![Donate to this project using Flattr](https://img.shields.io/badge/flattr-donate-yellow.svg)](https://flattr.com/profile/core23)
[![Donate to this project using PayPal](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://paypal.me/gripp)

This library provides a wrapper for using the [Setlist.fm API] inside PHP and a bridge for symfony.

### Installation

```
php composer.phar require core23/twig-extensions
```

### Symfony usage

#### Enabling the bundle

```php
    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            
            new Core23\TwigExtensions\Bridge\Symfony\Bundle\Core23TwigExtensionsBundle(),

            // ...
        );
    }
```

This lib / bundle is available under the [MIT license](LICENSE.md).

