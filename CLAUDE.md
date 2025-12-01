# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel Blade Minify Directive - A Laravel package that provides `@minify` / `@endminify` Blade directives for partial HTML compression. Unlike full-page minifiers, this allows selective minification of specific HTML sections.

## Commands

```bash
# Run all tests (PHPStan + PHPUnit)
composer test

# Run unit tests only
composer run test:unit

# Run static analysis only
composer run test:types

# Install dependencies
composer install

# Test with lowest dependency versions
composer update --prefer-lowest && composer run test:unit
```

## Architecture

The package consists of two main classes:

- **MinifyDirectiveServiceProvider** - Registers `@minify` and `@endminify` Blade directives using output buffering (`ob_start` / `ob_get_clean`)
- **Minifier** - Wrapper around `mrclay/minify` library's `Minify_HTML::minify()`

Tests use `orchestra/testbench` for Laravel integration testing. `MinifierTest` tests the Minifier class directly (extends PHPUnit TestCase), while `MinifyDirectiveTest` tests the Blade directive integration.

## Requirements

- PHP 8.2+
- Laravel 11.0+ / 12.0+
