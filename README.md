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

All geo data

```bash
make geo
```

Currencies

```bash
make currencies
```

Timezones

```bash
make timezones
```

Regions

```bash
make regions
```

Sub regions

```bash
make subregions
```

Countries

```bash
make countries
```

States

```bash
make states
```

Cities

```bash
make cities
```

Airports

```bash
make airports
```

### Data sources

https://github.com/dr5hn/countries-states-cities-database

https://gist.githubusercontent.com/Chanch95/6ae45e4dd8b5020bb368128f791347ea/raw/2c98c7ff5d241098de14644ac2a1af46ed4f85f2/airport.csv