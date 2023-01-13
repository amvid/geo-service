# State

### Create

POST /api/v1/states

Request

```json
{
  "title": "California",
  "code": "CA",
  "countryIso2": "US",
  "type": "state",
  "longitude": -119.418,
  "latitude": 36.778,
  "altitude": 10
}
```

Response 200

```json
{
  "id": "9054693c-6fa2-4e7b-b0ef-bf16e6167d5e",
  "title": "California",
  "code": "CA",
  "latitude": 36.778261,
  "longitude": -119.4179324,
  "altitude": 10,
  "type": "state",
  "country": {
    "id": "a02c5927-79f1-4c54-a66d-237f50dcf361",
    "title": "United States",
    "nativeTitle": "United States",
    "iso2": "US",
    "iso3": "USA",
    "numericCode": "840",
    "phoneCode": "1",
    "flag": "🇺🇸",
    "tld": ".us",
    "longitude": -97,
    "latitude": 38,
    "altitude": null,
    "currency": {
      "id": "c5e56330-649f-4c5e-852d-a9fb8fb0190d",
      "name": "US Dollar",
      "code": "USD",
      "symbol": "$"
    },
    "subRegion": {
      "id": "8bb7b205-695a-4c7d-b566-a716dac7e297",
      "title": "Northern America",
      "region": {
        "id": "387bde20-88ae-41c8-90fa-a2043918f73e",
        "title": "Americas"
      }
    },
    "timezones": [
      {
        "id": "1d7803f7-11f8-49c0-ba97-2b4aa86a247f",
        "title": "Eastern Standard Time (North America America/Indiana/Petersburg (EST)",
        "code": "America/Indiana/Petersburg",
        "utc": "UTC-05:00"
      },
      {
        "id": "2b1d9528-f910-4f50-a72f-3bf26a2d0167",
        "title": "Eastern Standard Time (North America America/Indiana/Vevay (EST)",
        "code": "America/Indiana/Vevay",
        "utc": "UTC-05:00"
      }
      // ...
    ]
  }
}
```

Error Response 409

```
State already exists.
```

### Update

PUT /api/v1/states/:id

Request (all body parameters are optional)

```json
{
  "title": "California Updated",
  "code": "CA",
  "countryIso2": "US",
  "type": "state",
  "longitude": -119.418,
  "latitude": 36.778,
  "altitude": 10
}
```

Response 200

```json
{
  "id": "9054693c-6fa2-4e7b-b0ef-bf16e6167d5e",
  "title": "California Updated",
  "code": "CA",
  "latitude": 36.778261,
  "longitude": -119.4179324,
  "altitude": 10,
  "type": "state",
  "country": {
    "id": "a02c5927-79f1-4c54-a66d-237f50dcf361",
    "title": "United States",
    "nativeTitle": "United States",
    "iso2": "US",
    "iso3": "USA",
    "numericCode": "840",
    "phoneCode": "1",
    "flag": "🇺🇸",
    "tld": ".us",
    "longitude": -97,
    "latitude": 38,
    "altitude": null,
    "currency": {
      "id": "c5e56330-649f-4c5e-852d-a9fb8fb0190d",
      "name": "US Dollar",
      "code": "USD",
      "symbol": "$"
    },
    "subRegion": {
      "id": "8bb7b205-695a-4c7d-b566-a716dac7e297",
      "title": "Northern America",
      "region": {
        "id": "387bde20-88ae-41c8-90fa-a2043918f73e",
        "title": "Americas"
      }
    },
    "timezones": [
      {
        "id": "1d7803f7-11f8-49c0-ba97-2b4aa86a247f",
        "title": "Eastern Standard Time (North America America/Indiana/Petersburg (EST)",
        "code": "America/Indiana/Petersburg",
        "utc": "UTC-05:00"
      },
      {
        "id": "2b1d9528-f910-4f50-a72f-3bf26a2d0167",
        "title": "Eastern Standard Time (North America America/Indiana/Vevay (EST)",
        "code": "America/Indiana/Vevay",
        "utc": "UTC-05:00"
      }
      // ...
    ]
  }
}
```

Error Response 404

```
State '044ee132-afc7-441f-84f9-36857c716eaf' not found.
```

### List

GET /api/v1/states

Query params

```
* Every parameter is optional, default offset is 0 and limit is 500

limit=2
offset=0
title=California
countryIso=US
code=CA
type=state
id=9054693c-6fa2-4e7b-b0ef-bf16e6167d5e
```

Response 200

```json
[
  {
    "id": "9054693c-6fa2-4e7b-b0ef-bf16e6167d5e",
    "title": "California Updated",
    "code": "CA",
    "latitude": 36.778261,
    "longitude": -119.4179324,
    "altitude": 10,
    "type": "state",
    "country": {
      "id": "a02c5927-79f1-4c54-a66d-237f50dcf361",
      "title": "United States",
      "nativeTitle": "United States",
      "iso2": "US",
      "iso3": "USA",
      "numericCode": "840",
      "phoneCode": "1",
      "flag": "🇺🇸",
      "tld": ".us",
      "longitude": -97,
      "latitude": 38,
      "altitude": null,
      "currency": {
        "id": "c5e56330-649f-4c5e-852d-a9fb8fb0190d",
        "name": "US Dollar",
        "code": "USD",
        "symbol": "$"
      },
      "subRegion": {
        "id": "8bb7b205-695a-4c7d-b566-a716dac7e297",
        "title": "Northern America",
        "region": {
          "id": "387bde20-88ae-41c8-90fa-a2043918f73e",
          "title": "Americas"
        }
      },
      "timezones": [
        {
          "id": "1d7803f7-11f8-49c0-ba97-2b4aa86a247f",
          "title": "Eastern Standard Time (North America America/Indiana/Petersburg (EST)",
          "code": "America/Indiana/Petersburg",
          "utc": "UTC-05:00"
        },
        {
          "id": "2b1d9528-f910-4f50-a72f-3bf26a2d0167",
          "title": "Eastern Standard Time (North America America/Indiana/Vevay (EST)",
          "code": "America/Indiana/Vevay",
          "utc": "UTC-05:00"
        }
        // ...
      ]
    }
  }
]
```

### Delete

DELETE /api/v1/states/:id

Response 200