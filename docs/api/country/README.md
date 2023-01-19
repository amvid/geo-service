# Country

### Create

POST /api/v1/countries

Request

```json
{
  "title": "Norway",
  "nativeTitle": "Norge",
  "iso2": "NO",
  "iso3": "NOR",
  "phoneCode": "47",
  "numericCode": "578",
  "subRegion": "Northern Europe",
  "currencyCode": "NOK",
  "flag": "🇳🇴",
  "tld": ".no",
  "latitude": 10.0,
  "longitude": 62.0,
  "timezones": [
    "Europe/Oslo"
  ]
}
```

Response 200

```json
{
  "id": "38d3ad9d-75c0-4640-b5f4-650ba2f9015b",
  "title": "Norway",
  "nativeTitle": "Norge",
  "iso2": "NO",
  "iso3": "NOR",
  "numericCode": "578",
  "phoneCode": "47",
  "flag": "🇳🇴",
  "tld": ".no",
  "longitude": 10,
  "latitude": 62,
  "altitude": null,
  "currency": {
    "id": "e8de8978-b7f0-4b3f-a2e8-d4306feb4d48",
    "name": "Norwegian Krone",
    "code": "NOK",
    "symbol": "kr"
  },
  "subRegion": {
    "id": "e592429a-9826-489e-a8bd-b3e90edab400",
    "title": "Northern Europe",
    "region": {
      "id": "ba8cdf1d-f2fb-47df-a2c9-9896fd05a73a",
      "title": "Europe"
    }
  },
  "timezones": [
    {
      "id": "ea5c1081-e732-450a-a29a-edcb64db7bec",
      "title": "Central European Time Europe/Oslo (CET)",
      "code": "Europe/Oslo",
      "utc": "UTC+01:00"
    }
  ]
}
```

Error response 409

```
Country already exists.
```

### Update

PUT /api/v1/countries/:id

Request (all body parameters are optional)

```json
{
  "title": "Norway Updated",
  "nativeTitle": "Norge",
  "iso2": "NO",
  "iso3": "NOR",
  "phoneCode": "47",
  "numericCode": "578",
  "subRegion": "Northern Europe",
  "currencyCode": "NOK",
  "flag": "🇳🇴",
  "tld": ".no",
  "latitude": 10.0,
  "longitude": 62.0,
  "timezones": [
    "Europe/Oslo"
  ]
}
```

Response 200

```json
{
  "id": "38d3ad9d-75c0-4640-b5f4-650ba2f9015b",
  "title": "Norway",
  "nativeTitle": "Norge",
  "iso2": "NO",
  "iso3": "NOR",
  "numericCode": "578",
  "phoneCode": "47",
  "flag": "🇳🇴",
  "tld": ".no",
  "longitude": 10,
  "latitude": 62,
  "altitude": null,
  "currency": {
    "id": "e8de8978-b7f0-4b3f-a2e8-d4306feb4d48",
    "name": "Norwegian Krone",
    "code": "NOK",
    "symbol": "kr"
  },
  "subRegion": {
    "id": "e592429a-9826-489e-a8bd-b3e90edab400",
    "title": "Northern Europe",
    "region": {
      "id": "ba8cdf1d-f2fb-47df-a2c9-9896fd05a73a",
      "title": "Europe"
    }
  },
  "timezones": [
    {
      "id": "ea5c1081-e732-450a-a29a-edcb64db7bec",
      "title": "Central European Time Europe/Oslo (CET)",
      "code": "Europe/Oslo",
      "utc": "UTC+01:00"
    }
  ]
}
```

Error response 404

```
Country '38d3ad9d-75c0-4640-b5f4-650ba2f9015b' not found.
```

### List

GET /api/v1/countries

Query params

```
* Every parameter is optional, default offset is 0 and limit is 500

limit=2
offset=0
id=38d3ad9d-75c0-4640-b5f4-650ba2f9015b
title=Norway
iso2=NO
iso3=NOR
numericCode=578
nativeTitle=Norge
phoneCode=47
tld=.no
currencyCode=NOK
subRegion=Northern Europe
```

Response 200

```json
[
  {
    "id": "38d3ad9d-75c0-4640-b5f4-650ba2f9015b",
    "title": "Norway",
    "nativeTitle": "Norge",
    "iso2": "NO",
    "iso3": "NOR",
    "numericCode": "578",
    "phoneCode": "47",
    "flag": "🇳🇴",
    "tld": ".no",
    "longitude": 10,
    "latitude": 62,
    "altitude": null,
    "currency": {
      "id": "e8de8978-b7f0-4b3f-a2e8-d4306feb4d48",
      "name": "Norwegian Krone",
      "code": "NOK",
      "symbol": "kr"
    },
    "subRegion": {
      "id": "e592429a-9826-489e-a8bd-b3e90edab400",
      "title": "Northern Europe",
      "region": {
        "id": "ba8cdf1d-f2fb-47df-a2c9-9896fd05a73a",
        "title": "Europe"
      }
    },
    "timezones": [
      {
        "id": "ea5c1081-e732-450a-a29a-edcb64db7bec",
        "title": "Central European Time Europe/Oslo (CET)",
        "code": "Europe/Oslo",
        "utc": "UTC+01:00"
      }
    ]
  }
]
```

### Delete

DELETE /api/v1/countries/:id

Response 200