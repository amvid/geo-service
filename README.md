# WIP Geo Service

## Info

Geo data REST API service with admin dashboard to manage regions, countries, timezones, states, cities and airports.

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

```
https://download.geonames.org/export/zip/
https://osmnames.org/download/
https://github.com/dr5hn/countries-states-cities-database
```