# Maintenance Bundle #

[![Build Status](https://travis-ci.com/siment/maintenance-bundle.svg?branch=master)](https://travis-ci.com/siment/maintenance-bundle)
[![Maintainability](https://api.codeclimate.com/v1/badges/ea0d42491249939be766/maintainability)](https://codeclimate.com/github/siment/symfony-maintenance-bundle/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/ea0d42491249939be766/test_coverage)](https://codeclimate.com/github/siment/symfony-maintenance-bundle/test_coverage)

## ABOUT ##

This bundle offers functionality related to maintaining an application that is deployed 
and in use in a production environment.

### Main features ###

1. Ability to put application in maintenance mode - which will deny incoming requests

## INSTALLATION ##

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 1: Add this repository to your composer.json ###

Since I have not decided whether to publish this bundle on Packagist or not, you will
have to add this repository to your project's `composer.json`. You can do it like this:

`composer config repositories.maintenance-bundle vcs git@github.com:siment/symfony-maintenance-bundle.git`

This will add the following section to your `composer.json`:

```
    "repositories": {
        "maintenance-bundle": {
            "type": "vcs",
            "url": "git@github.com:siment/maintenance-bundle.git"
        }
    }
```

### Step 2: Download the Bundle ###

Open a command console, enter your project directory and execute the following command
to download the latest stable version of this bundle:

```console
$ composer require siment/maintenance-bundle
```

### Step 3: Enable the Bundle ###

Then, enable the bundle by adding it to the list of registered bundles in the
`config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Siment\MaintenanceBundle\SimentMaintenanceBundle::class => ['all' => true],
];
```

## USAGE ##

### Commands ###

#### Enable maintenance mode ####

When maintenance mode is enabled, all requests will be denied with a *503 Service not available*
response.

Command: `php bin/console maintenance:enable`

#### Disable maintenance mode ####

Disables maintenance mode.

Command: `php bin/console maintenance:disable`

#### Get maintenance status ####

Command: `php bin/console maintenance:status`

- Outputs `Maintenance mode is DISABLED.` when application is *not* in maintenance mode.
- Outputs `Maintenance mode is ENABLED.` when application is in maintenance mode.

## TESTING ##

### Unit testing ###

The bundle is tested with `symfony/framework-bundle:^4` and `symfony/framework-bundle:^5`
on **PHP 7.2** and **PHP 7.3**. See build details on
[Travis CI](https://travis-ci.com/siment/symfony-maintenance-bundle).

To run tests locally, enter bundle source directory 
(`$PROJECT_ROOT/vendor/siment/maintenance-bundle`) and run:

```bash
$ composer install
$ vendor/bin/simple-phpunit
```

### Coding standards ###

[PHP Coding Standards Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) is used to enforce
[Symfony coding standards](https://symfony.com/doc/current/contributing/code/standards.html) and
[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) is used to enforce 
[PSR-12](https://www.php-fig.org/psr/psr-12/) coding style. [Psalm](https://github.com/vimeo/psalm) 
is used for static analysis for a
[large number of issues](https://github.com/vimeo/psalm/blob/master/docs/running_psalm/issues.md).

To run these locally, you can enter 
bundle source directory (`$PROJECT_ROOT/vendor/siment/maintenance-bundle`) and run:

```bash
$ composer install
$ vendor/bin/phpcs
$ vendor/bin/php-cs-fixer fix --dry-run
$ vendor/bin/psalm
```

## LICENSE ##

MIT. See [LICENSE](LICENSE).