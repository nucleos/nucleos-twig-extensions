Twig Extensions
===============
[![Latest Stable Version](https://poser.pugx.org/core23/twig-extensions/v/stable)](https://packagist.org/packages/core23/twig-extensions)
[![Latest Unstable Version](https://poser.pugx.org/core23/twig-extensions/v/unstable)](https://packagist.org/packages/core23/twig-extensions)
[![License](https://poser.pugx.org/core23/twig-extensions/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/core23/twig-extensions/downloads)](https://packagist.org/packages/core23/twig-extensions)
[![Monthly Downloads](https://poser.pugx.org/core23/twig-extensions/d/monthly)](https://packagist.org/packages/core23/twig-extensions)
[![Daily Downloads](https://poser.pugx.org/core23/twig-extensions/d/daily)](https://packagist.org/packages/core23/twig-extensions)

[![Continuous Integration](https://github.com/core23/twig-extensions/workflows/Continuous%20Integration/badge.svg)](https://github.com/core23/twig-extensions/actions)
[![Code Coverage](https://codecov.io/gh/core23/twig-extensions/branch/master/graph/badge.svg)](https://codecov.io/gh/core23/twig-extensions)

Useful extensions for twig.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this library:

```
composer require core23/twig-extensions
```

## Symfony usage

If you want to use this library inside symfony, you can use a bridge.

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Core23\Twig\Bridge\Symfony\Bundle\Core23TwigBundle::class => ['all' => true],
];
```

## License

This library is under the [MIT license](LICENSE.md).

