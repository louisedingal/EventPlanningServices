# Google Sign-In (Dingal mobile)

Uses the **system browser** → Symfony → deep link `dingal://oauth?token=...`.

## Why 127.0.0.1 (not 10.0.2.2)

Google **blocks OAuth redirect URIs on private IPs** (including `10.0.2.2`).  
Allowed for local development: **`http://127.0.0.1:8000/...`**

## Google Cloud Console (required — fixes `redirect_uri_mismatch`)

1. Go to [Google Cloud Console](https://console.cloud.google.com/) → **APIs & Services** → **Credentials**
2. Open your **Web application** OAuth 2.0 client (same `GOOGLE_OAUTH_CLIENT_ID`)
3. Under **Authorized redirect URIs**, add **exactly** (copy/paste):

```text
http://127.0.0.1:8000/api/google/mobile/callback
```

4. **Remove** wrong URIs if present, e.g.:
   - `http://10.0.2.2:8000/...` (Google blocks private IPs)
   - `http://localhost/api/google/mobile/callback` (missing port — this caused mismatch)
5. Click **Save** and wait 1–2 minutes

The backend now sends this exact URI to Google (configured via `GOOGLE_MOBILE_REDIRECT_URI`).

For **production** (real customers on phones), add your public HTTPS callback, e.g.:

```text
https://your-domain.com/api/google/mobile/callback
```

Set `GOOGLE_MOBILE_REDIRECT_URI` in `.env.local` to that URL and point the mobile app `API_BASE_URL` at the same host.

## Android emulator setup

**API + OAuth start:** the app uses `http://10.0.2.2:8000` (emulator alias for your PC).

**Google OAuth callback:** Google redirects to `http://127.0.0.1:8000/api/google/mobile/callback`.  
On the emulator, forward port 8000 **once per session** (required for Google sign-in to finish):

```powershell
adb reverse tcp:8000 tcp:8000
adb reverse tcp:8081 tcp:8081
```

Or from the Dingal folder: `npm run android:reverse`

**Symfony must be running:** `symfony server:start` (port 8000).

## Env (EventPlanning)

```env
GOOGLE_MOBILE_REDIRECT_URI=http://127.0.0.1:8000/api/google/mobile/callback
```

Restart Symfony after changing `.env`.
