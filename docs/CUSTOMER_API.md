# Customer Mobile API

REST API for the **Dingal** customer mobile app (React Native). All customer routes live under `/api/customer` and return a consistent JSON envelope.

## Authentication

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/api/login` | Public | Body: `{ "username", "password" }` — returns JWT + `customerApi` base path |
| POST | `/api/google` | Public | Body: `{ "idToken" }` — Google Sign-In (mobile); returns JWT |
| POST | `/api/register` | Public | Create account (email verification required) |
| POST | `/api/verify-email` | Public | Verify email token |
| POST | `/api/resend-verification` | Public | Resend verification email |
| GET | `/api/verification-status` | JWT | Current user verification state |

Send JWT on customer calls:

```
Authorization: Bearer <token>
```

## Response format

**Success**

```json
{
  "success": true,
  "data": { }
}
```

**List**

```json
{
  "success": true,
  "data": {
    "items": [],
    "total": 0
  }
}
```

**Error**

```json
{
  "success": false,
  "message": "Human-readable error"
}
```

## Customer endpoints

### Profile & dashboard

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/customer/me` | Logged-in customer profile |
| GET | `/api/customer/dashboard` | Summary: requests counts + catalog counts |

### Catalog (read-only)

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/customer/catalog` | All catalog sections in one response |
| GET | `/api/customer/catalog/venues` | List venues |
| GET | `/api/customer/catalog/venues/{id}` | Venue detail |
| GET | `/api/customer/catalog/themes` | List themes |
| GET | `/api/customer/catalog/themes/{id}` | Theme detail |
| GET | `/api/customer/catalog/packages` | List service packages |
| GET | `/api/customer/catalog/packages/{id}` | Package detail |
| GET | `/api/customer/catalog/events` | Browse sample events (portfolio) |
| GET | `/api/customer/catalog/events/{id}` | Event detail |

### Event requests (customer-owned)

| Method | Path | Description |
|--------|------|-------------|
| GET | `/api/customer/event-requests` | List **your** requests |
| POST | `/api/customer/event-requests` | Submit new request |
| GET | `/api/customer/event-requests/{id}` | Request detail (own only) |
| PUT | `/api/customer/event-requests/{id}` | Update **pending** request |
| DELETE | `/api/customer/event-requests/{id}` | Cancel **pending** request |

**Create / update body**

```json
{
  "eventType": "Wedding",
  "preferredDate": "2026-08-15",
  "estimatedGuestCount": 120,
  "preferredVenue": "Grand Ballroom",
  "theme": "Garden Elegance",
  "specialRequests": "Outdoor photo area",
  "budget": "150000"
}
```

## Test account (fixtures)

After `php bin/console doctrine:fixtures:load`:

- **Email / username:** `customer@gmail.com` or `customer`
- **Password:** `customer123`
- **Verified:** yes

## Mobile integration checklist

- [x] Login stores JWT
- [x] Catalog screens consume `/api/customer/catalog/*`
- [x] Event requests CRUD via `/api/customer/event-requests`
- [x] Profile uses `/api/customer/me`
- [x] Deep links map to app screens
- [x] CORS allows emulator (`10.0.2.2`) and localhost

## Staff vs customer

| Resource | Customer API | API Platform `/api/*` |
|----------|--------------|------------------------|
| Event requests | Own CRUD | Staff/admin only |
| Events | Read catalog | Staff write |
| Venues, themes, packages | Read catalog | Staff write |
