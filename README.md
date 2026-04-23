# Fetch Alert

Symfony + FrankenPHP + MySQL service running on Docker.

## Requirements

- Docker Engine + Compose v2.10+
- Free host ports: `80`, `443`, `33306`

## First run

```bash
make start   # build images, start containers, apply migrations
make seed    # load sample data
```

Other useful commands:

```bash
make down      # stop the containers
make bash      # shell into the php container
make analyze   # run Pint + PHPStan
```

## Database

Connection details:

| Field    | Value       |
| -------- | ----------- |
| Host     | `127.0.0.1` |
| Port     | `33306`     |
| User     | `app`       |
| Password | `app`       |
| Database | `app`       |

## Tests

First-time setup:

```bash
make test-init   # creates test schema
```

Run the suite:

```bash
make test
```

## API

### `GET /notifications`

List the notifications a user is eligible for.

**Query params**

| Name     | Type | Required |
| -------- | ---- | -------- |
| `userId` | int  | yes      |

**Response `200 OK`**

```json
[
  {
    "title": "Configurar dispositivo Android",
    "description": "…",
    "cta": "https://trendos.com/"
  }
]
```

**Example**

```bash
curl -k 'https://localhost/notifications?userId=2'
```
