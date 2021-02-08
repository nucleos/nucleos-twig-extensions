# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.2.0 - TBD

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.


## 2.1.0

### 🚀 Features

- Move configuration to PHP [@core23] ([#76])

### 📦 Dependencies

- Add support for PHP 8 [@core23] ([#150])
- Add support for twig 3 [@core23] ([#90])
- Drop support for PHP 7.2 [@core23] ([#87])

## 2.0.0

### Changes

- Renamed namespace `Core23\Twig` to `Nucleos\Twig` after move to [@nucleos]

  Run

  ```
  $ composer remove nucleos/twig-extensions
  ```

  and

  ```
  $ composer require nucleos/twig-extensions
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Core23\\Twig/Nucleos\\Twig/g' {} \;
  ```

  to replace occurrences of `Core23\Twig` with `Nucleos\Twig`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

## 1.4.1

### Changes

- Replace Makefile with composer scripts [@core23] ([#47])

### 🐛 Bug Fixes

- Fix template deprecations [@core23] ([#48])

## 1.4.0

### 📦 Dependencies

- Add support for symfony 5 [@core23] ([#27])

## 1.3.0

### Changes

- Modernize test files [@core23] ([#46])
- Enhancement: Use ergebnis/composer-normalize instead of localheinz/composer-normalize [@core23] ([#39])
- Add missing strict file header [@core23] ([#36])
- Drop support for symfony 3 [@core23] ([#33])
- Add missing twig bridge dependency [@core23] ([#26])
- Remove deprecated twig calls [@core23] ([#24])
- Use more precise type checks [@core23] ([#20])
- Removed twig deprecations [@core23] ([#19])
- Removed explicit private visibility of services [@core23] ([#16])
- Replace sonata intl with symfony intl [@core23] ([#40])

### 🚀 Features

- Use symfony translation contracts [@core23] ([#28])

[#48]: https://github.com/nucleos/nucleos-twig-extensions/pull/48
[#47]: https://github.com/nucleos/nucleos-twig-extensions/pull/47
[#46]: https://github.com/nucleos/nucleos-twig-extensions/pull/46
[#40]: https://github.com/nucleos/nucleos-twig-extensions/pull/40
[#39]: https://github.com/nucleos/nucleos-twig-extensions/pull/39
[#36]: https://github.com/nucleos/nucleos-twig-extensions/pull/36
[#33]: https://github.com/nucleos/nucleos-twig-extensions/pull/33
[#28]: https://github.com/nucleos/nucleos-twig-extensions/pull/28
[#27]: https://github.com/nucleos/nucleos-twig-extensions/pull/27
[#26]: https://github.com/nucleos/nucleos-twig-extensions/pull/26
[#24]: https://github.com/nucleos/nucleos-twig-extensions/pull/24
[#20]: https://github.com/nucleos/nucleos-twig-extensions/pull/20
[#19]: https://github.com/nucleos/nucleos-twig-extensions/pull/19
[#16]: https://github.com/nucleos/nucleos-twig-extensions/pull/16
[@nucleos]: https://github.com/nucleos
[@core23]: https://github.com/core23
[#150]: https://github.com/nucleos/nucleos-twig-extensions/pull/150
[#90]: https://github.com/nucleos/nucleos-twig-extensions/pull/90
[#87]: https://github.com/nucleos/nucleos-twig-extensions/pull/87
[#76]: https://github.com/nucleos/nucleos-twig-extensions/pull/76
