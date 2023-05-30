# Argentina Airports
This is a Laravel Package that imports the airports from Argentina into an airports table.

The airports data belongs to [datos.gob.ar](https://datos.gob.ar/dataset/transporte-lista-aeropuertos).

# Install Guide

This package can be installed through Composer.

```
composer require hmreumann/argentina-airports
```

Create the airports table.

```
php artisan migrate
```

Populate the airports table.

```
php artisan argentina-airports:import
```

# Contribution Guide
- Feel free to contribute to this package. Any suggestion is welcome.

# License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
