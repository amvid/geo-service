# WIP Geo Service

## Info

Geo data REST API service with admin dashboard to manage regions, countries, states, cities and airports.

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

### Sources
```
https://download.geonames.org/export/zip/
https://public.opendatasoft.com/api/v2/console
https://osmnames.org/download/
```

### Import

Timezones

```bash
make ssh
php bin/console app:import-timezones
```