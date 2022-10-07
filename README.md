# Mango 🥭

Mango is status manager of MineHub written in lemon. It basicaly stores all statues and allows you to change them via api.

## Installation

```sh
$ make
```

Then you have to provide tokens in .tokens and services in data.php. (both configurable in config)

## Api docs

### Get all services

This endpoint allows you to get all services with no authentication.

#### Endpoint

`GET /api/services/all`

#### Respose

Json of all services. E.g.:

```json
{
    "web": 1,
    "survival": 1,
    "identita": 0,
    "skyblock": 2
}
```

#### Statuses

| Code | Status      |
|------|-------------|
| 0    | offline     |
| 1    | online      |
| 2    | maintenance |

### Edit service

You can edit service via this endpoint, you must be authorized using token.

#### Endpoint

`POST /api/services/{service}/edit`

#### Request

Request must contain token and new status in json like this:

```json
{
    "token": "secret_token",
    "status": 0
}
```

where status can be 0, 1 or 2 as seen in table on upper table.

#### Response

If the token is not valid you get 401. If the status is not valid number, you get 400. If the service does not exist, you get 404. Otherwise 200.


