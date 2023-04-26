# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.6.0 - TBD

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

## 2.5.0 - 2023-04-26


-----

### Release Notes for [2.5.0](https://github.com/nucleos/nucleos-twig-extensions/milestone/8)

Feature release (minor)

### 2.5.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **1**

#### Enhancement

 - [446: Add type hints](https://github.com/nucleos/nucleos-twig-extensions/pull/446) thanks to @core23
 - [445: Update build tools](https://github.com/nucleos/nucleos-twig-extensions/pull/445) thanks to @core23

#### dependency

 - [444: Drop support for PHP 8.0](https://github.com/nucleos/nucleos-twig-extensions/pull/444) thanks to @core23

## 2.4.0 - 2022-12-17


-----

### Release Notes for [2.4.0](https://github.com/nucleos/nucleos-twig-extensions/milestone/6)

Feature release (minor)

### 2.4.0

- Total issues resolved: **0**
- Total pull requests resolved: **1**
- Total contributors: **1**

#### dependency,hacktoberfest-accepted

 - [437: Update dependency symfony/translation-contracts to ^1.1 || ^2.0 || ^3.0](https://github.com/nucleos/nucleos-twig-extensions/pull/437) thanks to @core23

## 2.3.0 - 2022-02-21


-----

### Release Notes for [2.3.0](https://github.com/nucleos/nucleos-twig-extensions/milestone/3)

Feature release (minor)

### 2.3.0

- Total issues resolved: **0**
- Total pull requests resolved: **4**
- Total contributors: **1**

#### Enhancement

 - [357: Use shared pipelines](https://github.com/nucleos/nucleos-twig-extensions/pull/357) thanks to @core23
 - [345: Remove composer-bin plugin](https://github.com/nucleos/nucleos-twig-extensions/pull/345) thanks to @core23
 - [344: Deprecate `page&#95;pager` function](https://github.com/nucleos/nucleos-twig-extensions/pull/344) thanks to @core23
 - [343: Prefer pager interface](https://github.com/nucleos/nucleos-twig-extensions/pull/343) thanks to @core23

## 2.2.0 - 2021-12-05



-----

### Release Notes for [2.2.0](https://github.com/nucleos/nucleos-twig-extensions/milestone/1)



### 2.2.0

- Total issues resolved: **0**
- Total pull requests resolved: **4**
- Total contributors: **1**

#### dependency

 - [338: Add support for symfony 6](https://github.com/nucleos/nucleos-twig-extensions/pull/338) thanks to @core23
 - [337: Bump symfony 5.4](https://github.com/nucleos/nucleos-twig-extensions/pull/337) thanks to @core23
 - [334: Drop PHP 7 support](https://github.com/nucleos/nucleos-twig-extensions/pull/334) thanks to @core23

#### Enhancement

 - [336: Update tools and use make to run them](https://github.com/nucleos/nucleos-twig-extensions/pull/336) thanks to @core23

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
