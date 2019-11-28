# Maintenance Bundle #

## About ##

This bundle offers functionality related to maintaining an application
that is deployed and in use in a production environment.

### Main features ###

1. Ability to put application in maintenance mode - which will deny
incoming requests

## Installation ##

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require siment/maintenance-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Siment\MaintenanceBundle\SimentMaintenanceBundle::class => ['all' => true],
];
```

## Usage ##

Please see [Resources/doc/index.md](Resources/doc/index.md)

## License ##

Please se [LICENSE](LICENSE)