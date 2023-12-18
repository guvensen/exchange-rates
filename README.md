# An Exchange Rates API

## Currencies Supported
| Code  | Name            | Symbol  |
|-------|-----------------|---------|
| TRY   | Turkish Lira    | ₺       |
| EUR   | Euro            | €       |
| RUB   | Russian Ruble   | ₽       |
| CAD   | Canadian Dollar | $       |
| BGN   | Bulgarian Lev   | лв      |


## Swagger Documentation

[Documentation](https://exchange-rates.guvensen.com/api/swagger)

## API Url

[API Url](https://exchange-rates.guvensen.com/api)


## Endpoints
| Method | Endpoint              | Description                        | parameters            | type         |
|--------|-----------------------|------------------------------------|-----------------------|--------------|
| POST   | /user                 | Create new user                    | name, email, password | Body (json)  |
| POST   | /auth/login           | Login                              | email, password       | Body (json)  |
| POST   | /auth/logout          | Logout                             | email, password       | Body (json)  |
| GET    | /currency/{code}      | Get a dollar based currency detail | code                  | path         |
| GET    | /currency/rate/{code} | Get a dollar based exchange rate   | code                  | path         |
| GET    | /currency/convert     | Convert money from x to y.         | from, to, amount      | query        |
| GET    | /user/logs            | Get user logs by email.            | email                 | query        |
