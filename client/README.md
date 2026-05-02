# Equipment Tracker Client (React)

This client is built for a client-server setup and calls the Laravel API in `server/`.

## Setup

1. Copy `.env.example` to `.env`.
2. Update `REACT_APP_API_BASE_URL` if needed.
3. Install dependencies:

```powershell
npm install
```

4. Run development server:

```powershell
npm start
```

## Default API URL

`http://127.0.0.1:8000/api`

## Required API endpoints

- `POST /login`
- `POST /logout`
- `GET /dashboard/stats`
- `GET /equipments`
- `POST /equipments`
- `DELETE /equipments/{id}`
- `GET /assignments`
- `POST /assignments`
- `PATCH /assignments/{id}/return`

## Notes

- Authentication token is stored in localStorage as `auth_token` for demo simplicity.
- For production, prefer secure cookie strategy with CSRF protection.
