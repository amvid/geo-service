# Airport

### Create

POST /api/v1/airports

Request
```json
{
  "title": "Trondheim Airport Vaernes",
  "cityTitle": "Trondheim",
  "timezone": "Europe/Oslo",
  "iata": "TRD",
  "icao": "ENVA",
  "longitude": 10.9239997864,
  "latitude": 63.4578018188
}
```

Response 200
```json
{
  "id": "a6394382-f2f5-42b6-9e92-f1f9a357045a",
  "title": "Trondheim Airport Vaernes",
  "iata": "TRD",
  "icao": "ENVA",
  "longitude": 10.9239997864,
  "latitude": 63.4578018188,
  "altitude": null,
  "timezone": {
    "id": "1013a9a5-1427-4e5b-8971-b97a442fb3cb",
    "title": "Central European Time Europe/Oslo (CET)",
    "code": "Europe/Oslo",
    "utc": "UTC+01:00"
  },
  "city": {
    "id": "72ebbfde-d2b0-48a1-961e-092a2057ef0a",
    "title": "Trondheim",
    "longitude": 10.9239997864,
    "latitude": 63.4578018188,
    "altitude": null,
    "state": null,
    "country": {
      "id": "20a21c8b-4003-482a-83c5-7dbf816d20f2",
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
        "id": "06f8198b-6c60-4cfe-afa0-4c65ebb1002f",
        "name": "Norwegian Krone",
        "code": "NOK",
        "symbol": "kr",
        "createdAt": "2023-01-10T18:14:07+00:00",
        "updatedAt": "2023-01-10T18:14:07+00:00"
      },
      "subRegion": {
        "id": "a2543731-e2a1-4f19-b89e-20b8948b7317",
        "title": "Northern Europe",
        "region": {
          "id": "40c05d1c-f88b-4aad-9754-e1a597797160",
          "title": "Europe"
        }
      },
      "timezones": [
        {
          "id": "1013a9a5-1427-4e5b-8971-b97a442fb3cb",
          "title": "Central European Time Europe/Oslo (CET)",
          "code": "Europe/Oslo",
          "utc": "UTC+01:00"
        }
      ]
    }
  }
}
```

Error Response 409
```
Airport already exists.
```

### Update

PUT /api/v1/airports/:id

Request (all body parameters are optional)
```json
{
  "title": "Trondheim Airport Vaernes Updated",
  "cityTitle": "Trondheim",
  "timezone": "Europe/Oslo",
  "iata": "TRD",
  "icao": "ENVA",
  "longitude": 10.9239997864,
  "latitude": 63.4578018188
}
```

Response 200
```json
{
    "id": "a6394382-f2f5-42b6-9e92-f1f9a357045a",
    "title": "Trondheim Airport Vaernes Updated",
    "iata": "TRD",
    "icao": "ENVA",
    "longitude": 10.9239997864,
    "latitude": 63.4578018188,
    "altitude": null,
    "timezone": {
        "id": "1013a9a5-1427-4e5b-8971-b97a442fb3cb",
        "title": "Central European Time Europe/Oslo (CET)",
        "code": "Europe/Oslo",
        "utc": "UTC+01:00"
    },
    "city": {
        "id": "72ebbfde-d2b0-48a1-961e-092a2057ef0a",
        "title": "Trondheim",
        "longitude": 10.9239997864,
        "latitude": 63.4578018188,
        "altitude": null,
        "state": null,
        "country": {
            "id": "20a21c8b-4003-482a-83c5-7dbf816d20f2",
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
                "id": "06f8198b-6c60-4cfe-afa0-4c65ebb1002f",
                "name": "Norwegian Krone",
                "code": "NOK",
                "symbol": "kr",
                "createdAt": "2023-01-10T18:14:07+00:00",
                "updatedAt": "2023-01-10T18:14:07+00:00"
            },
            "subRegion": {
                "id": "a2543731-e2a1-4f19-b89e-20b8948b7317",
                "title": "Northern Europe",
                "region": {
                    "id": "40c05d1c-f88b-4aad-9754-e1a597797160",
                    "title": "Europe"
                }
            },
            "timezones": [
                {
                    "id": "1013a9a5-1427-4e5b-8971-b97a442fb3cb",
                    "title": "Central European Time Europe/Oslo (CET)",
                    "code": "Europe/Oslo",
                    "utc": "UTC+01:00"
                }
            ]
        }
    }
}
```

Error Response 404

```
Airport 'a6394382-f2f5-42b6-9e92-f1f9a357045a' not found.
```

### List

GET /api/v1/airports

Query params
```
* Every parameter is optional, default offset is 0 and limit is 500

limit=2
offset=0
cityTitle=Trondheim
timezone=Europe/Oslo
iata=TRD
icao=ENVA
id=a6394382-f2f5-42b6-9e92-f1f9a357045a
```

Response
```json
[
  {
    "id": "a6394382-f2f5-42b6-9e92-f1f9a357045a",
    "title": "Trondheim Airport Vaernes Updated",
    "iata": "TRD",
    "icao": "ENVA",
    "longitude": 10.9239997864,
    "latitude": 63.4578018188,
    "altitude": null,
    "timezone": {
      "id": "1013a9a5-1427-4e5b-8971-b97a442fb3cb",
      "title": "Central European Time Europe/Oslo (CET)",
      "code": "Europe/Oslo",
      "utc": "UTC+01:00"
    },
    "city": {
      "id": "72ebbfde-d2b0-48a1-961e-092a2057ef0a",
      "title": "Trondheim",
      "longitude": 10.9239997864,
      "latitude": 63.4578018188,
      "altitude": null,
      "state": null,
      "country": {
        "id": "20a21c8b-4003-482a-83c5-7dbf816d20f2",
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
          "id": "06f8198b-6c60-4cfe-afa0-4c65ebb1002f",
          "name": "Norwegian Krone",
          "code": "NOK",
          "symbol": "kr",
          "createdAt": "2023-01-10T18:14:07+00:00",
          "updatedAt": "2023-01-10T18:14:07+00:00"
        },
        "subRegion": {
          "id": "a2543731-e2a1-4f19-b89e-20b8948b7317",
          "title": "Northern Europe",
          "region": {
            "id": "40c05d1c-f88b-4aad-9754-e1a597797160",
            "title": "Europe"
          }
        },
        "timezones": [
          {
            "id": "1013a9a5-1427-4e5b-8971-b97a442fb3cb",
            "title": "Central European Time Europe/Oslo (CET)",
            "code": "Europe/Oslo",
            "utc": "UTC+01:00"
          }
        ]
      }
    }
  }
]
```

### Delete

DELETE /api/v1/airports/:id

Response 200
