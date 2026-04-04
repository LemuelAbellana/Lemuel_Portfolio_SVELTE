# Deploy Laravel Portfolio on Contabo + CloudPanel + Cloudflare (Docker-First)

This guide deploys this project to:
- VPS: Contabo (Ubuntu)
- Panel: CloudPanel
- Domain: `portfolio.lemuel-abellana.dev` (Cloudflare)
- Runtime: Full Docker stack (Nginx + Laravel PHP-FPM + MySQL)

Goal: secure and simple deployment, without overengineering.

---

## 1) Test First (Required Gate)

Run tests locally before touching production:

```bash
composer install
npm ci
php artisan test
npm run build
```

You should only deploy if tests and build pass.

---

## 2) VPS Baseline Hardening (One Time)

SSH into VPS as root, then create a sudo user (replace `lemuel`):

```bash
adduser lemuel
usermod -aG sudo lemuel
```

Basic hardening:

```bash
apt update && apt upgrade -y
apt install -y ufw fail2ban ca-certificates curl gnupg

ufw default deny incoming
ufw default allow outgoing
ufw allow OpenSSH
ufw allow 80/tcp
ufw allow 443/tcp
ufw enable
```

Disable root/password SSH login in `/etc/ssh/sshd_config`:

```text
PermitRootLogin no
PasswordAuthentication no
PubkeyAuthentication yes
```

Then:

```bash
systemctl restart ssh
```

---

## 3) Install Docker (for Full Stack)

```bash
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
chmod a+r /etc/apt/keyrings/docker.asc

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo $VERSION_CODENAME) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null

apt update
apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
systemctl enable docker
systemctl start docker
```

---

## 4) Create Docker Stack (App + Nginx + MySQL)

Use the Docker files committed in this repository:
- `Dockerfile`
- `docker-compose.yml`
- `docker/nginx/default.conf`
- `.env.stack.example`

Copy the repo to the server, then create the real MySQL secrets file from example:

```bash
cd /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
cp .env.stack.example .env.stack
```

Set secure values in `.env.stack`:

```env
MYSQL_ROOT_PASSWORD=CHANGE_THIS_STRONG_ROOT_PASSWORD
MYSQL_DATABASE=portfolio_lemuel
MYSQL_USER=portfolio_user
MYSQL_PASSWORD=CHANGE_THIS_STRONG_APP_PASSWORD
```

The committed `docker-compose.yml` should contain:

```yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    restart: unless-stopped
    working_dir: /var/www
    env_file:
      - .env
    volumes:
      - ./:/var/www
    depends_on:
      mysql:
        condition: service_healthy

  web:
    image: nginx:1.27-alpine
    restart: unless-stopped
    ports:
      - "127.0.0.1:8080:80"
    volumes:
      - ./:/var/www:ro
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
    depends_on:
      - app

  mysql:
    image: mysql:8.4
    restart: unless-stopped
    command: --default-authentication-plugin=mysql_native_password --skip-name-resolve
    env_file:
      - .env.stack
    ports:
      - "127.0.0.1:3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "127.0.0.1", "-uroot", "-p$${MYSQL_ROOT_PASSWORD}"]
      interval: 10s
      timeout: 5s
      retries: 12

volumes:
  mysql_data:
```

Start stack:

```bash
docker compose up -d
```

Verify:

```bash
docker ps
docker compose logs --tail=100 web
docker compose logs --tail=100 app
docker compose logs --tail=100 mysql
```

---

## 5) CloudPanel Setup (Reverse Proxy to Docker)

In CloudPanel:
1. Add Site -> Create Reverse Proxy Site
2. Domain: `portfolio.lemuel-abellana.dev`
3. Proxy target: `http://127.0.0.1:8080`
4. Enable HTTPS and force redirect

Recommended project path example:

```text
/home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
```

---

## 6) Add SSH Key for GitHub (Faster + Secure Deploy)

As the CloudPanel site user (or deploy user):

```bash
ssh-keygen -t ed25519 -C "deploy@portfolio.lemuel-abellana.dev"
cat ~/.ssh/id_ed25519.pub
```

Add the public key to GitHub:
- Option A: Repo Deploy Key (recommended, read-only)
- Option B: Machine user key

Trust GitHub host key:

```bash
ssh-keyscan github.com >> ~/.ssh/known_hosts
chmod 600 ~/.ssh/known_hosts
```

Test:

```bash
ssh -T git@github.com
```

Clone app:

```bash
git clone git@github.com:<your-username>/<your-repo>.git /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
cd /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
```

---

## 7) Configure Laravel for Docker Production

Create production env:

```bash
cp .env .env.production
```

Set in `.env.production` (minimum):

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://portfolio.lemuel-abellana.dev

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=portfolio_lemuel
DB_USERNAME=portfolio_user
DB_PASSWORD=CHANGE_THIS_STRONG_APP_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

Use the production env file:

```bash
cp .env.production .env
```

Build and start Docker app:

```bash
cd /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
docker compose up -d --build
```

Install dependencies, build assets, run migrations inside container:

```bash
docker compose exec app composer install --no-dev --optimize-autoloader
docker compose exec app npm ci
docker compose exec app npm run build
docker compose exec app php artisan key:generate --force
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize
```

Permissions:

```bash
chown -R <site-user>:<site-user> /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

---

## 8) Cloudflare + SSL

In Cloudflare DNS:
- Type: `A`
- Name: `portfolio`
- Value: `<YOUR_VPS_IP>`
- Proxy: Proxied (orange cloud) after validation

SSL/TLS mode in Cloudflare:
- Use `Full (strict)`

In CloudPanel:
- Issue SSL certificate for `portfolio.lemuel-abellana.dev`
- Force HTTPS redirect

---

## 9) Production Test Checklist (Run on VPS)

App and DB checks:

```bash
cd /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
docker compose exec app php artisan about
docker compose exec app php artisan migrate:status
docker compose exec app php artisan route:list
docker compose exec app php artisan test
curl -I http://127.0.0.1:8080
curl -I https://portfolio.lemuel-abellana.dev
```

Contact form DB write test (manual):
1. Submit contact form from live site
2. Verify in DB:

```bash
docker compose exec mysql mysql -uportfolio_user -p portfolio_lemuel -e "SELECT id,name,email,created_at FROM contacts ORDER BY id DESC LIMIT 5;"
```

If all checks pass, deployment is successful.

---

## 10) Security Controls Against Common Red-Team Paths

Keep these enabled:
- `APP_DEBUG=false` always in production
- No root DB use by app (use `portfolio_user` only)
- MySQL bound to `127.0.0.1` only (already done)
- Web container bound to `127.0.0.1:8080` only (CloudPanel proxies it)
- UFW only open: `22`, `80`, `443`
- SSH key-only auth, root SSH disabled
- Regular patching:

```bash
apt update && apt upgrade -y
```

- Rotate secrets immediately if exposed (especially old DB password)
- Backup MySQL volume and app `.env` securely

---

## 11) Minimal Redeploy Flow

When updating code:

```bash
cd /home/cloudpanel/htdocs/portfolio.lemuel-abellana.dev
git pull origin main
docker compose exec app composer install --no-dev --optimize-autoloader
docker compose exec app npm ci && docker compose exec app npm run build
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize
docker compose up -d --build
```

Quick health check:

```bash
curl -I http://127.0.0.1:8080
curl -I https://portfolio.lemuel-abellana.dev
```

Done.
