RAILWAY + LARAVEL + APACHE FIX ("More than one MPM loaded")

1. Extract this zip into the ROOT of your Laravel project
   (Dockerfile must sit next to artisan and composer.json).
   Final layout:
       your-project/
         Dockerfile
         .dockerignore
         docker/start.sh
         artisan, composer.json, app/, ...

2. Commit and push:
       git add Dockerfile .dockerignore docker/start.sh
       git commit -m "Fix Apache MPM on Railway"
       git push

3. In Railway, make sure the service builder is set to "Dockerfile"
   (Settings > Build). Remove any custom Start Command so the
   Dockerfile CMD is used.

4. Set variables in Railway: APP_KEY, APP_ENV=production,
   APP_URL, and your DB_* variables.

Notes:
- If you use a different PHP version, change the first line of the Dockerfile.
- If your app needs Vite/npm assets built, add a Node build stage or commit the built assets.
- To skip auto-migrations, delete the "php artisan migrate" line in docker/start.sh.
