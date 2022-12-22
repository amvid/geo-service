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

Currencies

```bash
make ssh
php bin/console app:import-currencies
```

Timezones

```bash
make ssh
php bin/console app:import-timezones
```

Regions

```bash
make ssh
php bin/console app:import-regions
```

Sub regions

```bash
make ssh
php bin/console app:import-subregions
```

### Data sources

https://download.geonames.org/export/zip

https://osmnames.org/download/

https://github.com/dr5hn/countries-states-cities-database
