{
  "$schema": "https://openapi.vercel.sh/vercel.json",
  "functions": {
    "api/*.php": {
      "runtime": "vercel-php@0.9.0"
    }
  },
  "routes": [
    {
      "src": "^/api\\.php$",
      "dest": "/api/api.php"
    },
    {
      "src": "^/db-check\\.php$",
      "dest": "/api/db-check.php"
    },
    {
      "src": "/(.*)",
      "dest": "/api/index.php"
    }
  ]
}
