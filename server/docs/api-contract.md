# Equipment Tracker API Contract

All responses should follow this envelope:

```json
{
  "success": true,
  "message": "Human-readable message",
  "data": {}
}
```

## Auth

### POST /api/login
Request:

```json
{
  "email": "admin@example.com",
  "password": "secret"
}
```

Response:

```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "plain-text-token"
  }
}
```

### POST /api/logout
Response:

```json
{
  "success": true,
  "message": "Logout successful",
  "data": null
}
```

## Equipment

### GET /api/equipments
### POST /api/equipments
### GET /api/equipments/{id}
### PUT /api/equipments/{id}
### DELETE /api/equipments/{id}

## Assignments

### GET /api/assignments
### POST /api/assignments
### PATCH /api/assignments/{id}/return

## Dashboard

### GET /api/dashboard/stats
Returns total, available, assigned, overdue counts.
