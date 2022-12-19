# WIP GeoService

## Info

Geo data REST API service with admin dashboard to manage regions, countries, timezones, states, cities and airports.

[PHP8.2](https://www.php.net/releases/8.2/en.php) |
[Symfony 6](https://symfony.com) |
[EasyAdminBundle](https://symfony.com/bundles/EasyAdminBundle/current/index.html)

### Installation

```bash
make install
make migrate
```

### Create a user

```bash
make ssh
php bin/console app:create-user
```

### Tests

```bash
make test
```

### Import

Timezones

```bash
make ssh
php bin/console app:import-timezones
```

### Data sources

https://download.geonames.org/export/zip

https://osmnames.org/download/

https://github.com/dr5hn/countries-states-cities-database
