Twig Extensions
===============
[![Latest Stable Version](https://poser.pugx.org/nucleos/twig-extensions/v/stable)](https://packagist.org/packages/nucleos/twig-extensions)
[![Latest Unstable Version](https://poser.pugx.org/nucleos/twig-extensions/v/unstable)](https://packagist.org/packages/nucleos/twig-extensions)
[![License](https://poser.pugx.org/nucleos/twig-extensions/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/nucleos/twig-extensions/downloads)](https://packagist.org/packages/nucleos/twig-extensions)
[![Monthly Downloads](https://poser.pugx.org/nucleos/twig-extensions/d/monthly)](https://packagist.org/packages/nucleos/twig-extensions)
[![Daily Downloads](https://poser.pugx.org/nucleos/twig-extensions/d/daily)](https://packagist.org/packages/nucleos/twig-extensions)

[![Continuous Integration](https://github.com/nucleos/nucleos-twig-extensions/workflows/Continuous%20Integration/badge.svg)](https://github.com/nucleos/nucleos-twig-extensions/actions)
[![Code Coverage](https://codecov.io/gh/nucleos/nucleos-twig-extensions/branch/main/graph/badge.svg)](https://codecov.io/gh/nucleos/nucleos-twig-extensions)

Useful extensions for twig.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this library:

```
composer require nucleos/twig-extensions
```

## Symfony usage

If you want to use this library inside symfony, you can use a bridge.

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Nucleos\Twig\Bridge\Symfony\Bundle\NucleosTwigBundle::class => ['all' => true],
];
```

## License

This library is under the [MIT license](LICENSE.md).

