# Psalm plugin for Laravel

[![Packagist](https://img.shields.io/packagist/v/brokeyourbike/plugin-laravel.svg)](https://packagist.org/packages/brokeyourbike/plugin-laravel)
[![Packagist](https://img.shields.io/packagist/dt/brokeyourbike/plugin-laravel.svg)](https://packagist.org/packages/brokeyourbike/plugin-laravel)
![Type coverage](https://shepherd.dev/github/brokeyourbike/psalm-plugin-laravel/coverage.svg)
![Tests](https://img.shields.io/github/workflow/status/brokeyourbike/psalm-plugin-laravel/Run%20Tests?label=tests)

## Overview
This package brings static analysis and type support to projects using Laravel 8. Our goal is to find as many type-related
bugs as possible, therefore increasing developer productivity and application health. Find bugs without the overhead
of writing tests!

![Screenshot](/assets/screenshot.png)

## Quickstart
Please refer to the [full Psalm documentation](https://psalm.dev/quickstart) for a more detailed guide on introducing Psalm
into your project.

First, start by installing Psalm if you have not done so already:
```bash
composer require --dev vimeo/psalm
./vendor/bin/psalm --init
```

Next, install this package and enable the plugin
```bash
composer require --dev brokeyourbike/plugin-laravel
./vendor/bin/psalm-plugin enable brokeyourbike/plugin-laravel
```

Finally, run Psalm to analyze your codebase
```bash
./vendor/bin/psalm
```

## How it works

Under the hood it just runs https://github.com/barryvdh/laravel-ide-helper and feeds the resultant stubs into Psalm, which can read PhpStorm meta stubs.

It also parses any database migrations it can find to try to understand property types in your database models.
