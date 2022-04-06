Just2trade Doctrine Extension
==================

[![Tests](https://github.com/FinamWeb/doctrine-extensions/actions/workflows/tests.yml/badge.svg)](https://github.com/FinamWeb/doctrine-extensions/actions/workflows/tests.yml)

This package contains useful functions of PgSQL implemented for Doctrine DQL

* DateTrunc
* Every
* InArray
* Right
* ToChar

Installation
------------

To install this package, run the command below, and you will get the latest version:

```sh
composer require just2trade/doctrine-extensions
```

In order to run tests:

```sh
./vendor/bin/phpunit
```

Note: you have to enable sqlite ext. in php.ini to run tests