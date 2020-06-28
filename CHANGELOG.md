# 2.0.0

## Changes

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

# 1.4.1

## Changes

- Replace Makefile with composer scripts @core23 (#47)

## 🐛 Bug Fixes

- Fix template deprecations @core23 (#48)

# 1.4.0

## 📦 Dependencies

- Add support for symfony 5 @core23 (#27)

# 1.3.0

## Changes

- Modernize test files @core23 (#46)
- Enhancement: Use ergebnis/composer-normalize instead of localheinz/composer-normalize @core23 (#39)
- Add missing strict file header @core23 (#36)
- Drop support for symfony 3 @core23 (#33)
- Add missing twig bridge dependency @core23 (#26)
- Remove deprecated twig calls @core23 (#24)
- Use more precise type checks @core23 (#20)
- Removed twig deprecations @core23 (#19)
- Removed explicit private visibility of services @core23 (#16)
- Replace sonata intl with symfony intl @core23 (#40)

## 🚀 Features

- Use symfony translation contracts @core23 (#28)
