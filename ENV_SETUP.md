# Environment Setup

This project now has two environment files:

- `.env.development` for local development
- `.env.production` for deployment (`https://knowitgel1.fun`)

## Local Development

1. Copy local env:
   - `copy .env.development .env`
2. Generate app key (first time only):
   - `php artisan key:generate`
3. Run app:
   - `php artisan serve`
   - `pnpm run dev`

## Production (Hostinger)

1. Update DB credentials inside `.env.production`.
2. Copy production env:
   - `copy .env.production .env`
3. Build assets locally:
   - `pnpm run build`
4. Upload to host:
   - Laravel app files
   - `public/build` folder
5. On server, clear and cache config:
   - `php artisan optimize:clear`
   - `php artisan config:cache`
6. Ensure these files do NOT exist on server:
   - `public/hot`
   - `storage/framework/vite.hot`

If `@vite/client` or `:5173` still appears in page source, production is still reading hot-file mode.
