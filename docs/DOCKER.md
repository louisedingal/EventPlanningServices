# Docker & Railway deployment

## Local Docker (before `docker compose up --build`)

1. **Docker Desktop** running.
2. Copy secrets into **`.env.local`** (optional overrides) from `.env.example`.
3. Ensure **`.env`** has `APP_SECRET`, `BREVO_SMTP_USER`, `BREVO_SMTP_KEY`, and Google OAuth values.
4. Free ports **8000** (app), **3307** (MySQL), **8080** (phpMyAdmin).

```powershell
cd "c:\Users\lucky\OneDrive\Desktop\webdev_final\EventPlanning"
docker compose up --build
```

- App: http://127.0.0.1:8000  
- phpMyAdmin: http://127.0.0.1:8080  

Migrations run automatically on container start.

## Railway

1. Connect the **EventPlanning** GitHub repo; Railway uses `Dockerfile` + `railway.toml`.
2. Add **MySQL** and link `DATABASE_URL`.
3. Set variables from `config/deploy.env.example` (especially `APP_URL`, `BREVO_API_KEY`, `JWT_PASSPHRASE`, OAuth).
4. **Networking → Public port `8080`** (match `PORT` in deploy logs).
5. Google Cloud redirect URIs:
   - `https://<domain>/connect/google/check`
   - `https://<domain>/api/google/mobile/callback` (mobile)

Test email after deploy:

```bash
php bin/console app:test-email you@example.com
```
