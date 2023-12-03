```sh
composer require laravel/breeze --dev
php artisan breeze:install api 
```

```env
APP_URL=http://api.blog-local.com

FRONTEND_URL=http://blog-local.com:3000
# Incase be and fe domain are difference we must specify SESSION_DOMAIN
# The set-cookie will apply for be (api.blog-local.com) not fe( blog-local.com)
# XSRF-TOKEN cookie will empty → axios can't get XSRF-TOKEN → X-CSRF-TOKEN header empty
#SESSION_DOMAIN=.blog-local.com
SANCTUM_STATEFUL_DOMAINS=blog-local.com:3000
```

## React
```tsx
useEffect(() => {
  const fetch = async () => {
    axios.defaults.withCredentials = true;
    // It uses for create CSRF-TOKEN cookie
    // CSRF-TOKEN cookie use for POST request
    await axios.get('http://api.blog-local.com/sanctum/csrf-cookie');

    await axios.post('http://api.blog-local.com/login', {
      email: 'test@test.test',
      password: 'password',
    });

    await axios.get('http://api.blog-local.com/api/user');
  };

  fetch();
}, []);
```
## Login with Google
- https://console.cloud.google.com/apis/credentials?project=blog-395101
- https://github.com/pnlinh-it/blog-be/pull/2

Put `Route::get('/api/oauth/google/callback', handler)` into `routes/web.php`

```php
/**
 * Put that route to use web's middleware @see \App\Http\Kernel
 *
 * That will ensure Cookie is set after google redirect user to our callback
 * By default api route has no Cookie middleware
 * But Sanctum add EnsureFrontendRequestsAreStateful middleware to handle Cookie
 * EnsureFrontendRequestsAreStateful check referer or origin but Google redirect has no these headers
 * @see EnsureFrontendRequestsAreStateful::fromFrontend()
 */
Route::get('/api/oauth/google/callback', [GoogleLoginController::class, 'callback']);
```

### Use both frontend and backend for same domain with nginx
```conf
server {
    listen 80;
    server_name blog-local.com;
    server_tokens off;

    location / {
        return 301 https://$host$request_uri;
    }
}
server {
        server_name blog-local.com;
        listen 443 ssl ;
        location / {
            proxy_pass http://localhost:3000;
            set $upstream_keepalive false;
        }
        location /api/ {
            proxy_pass http://blog-local.com:8080/api/;
        }
        location /ws {
            proxy_pass              http://localhost:3000;
            proxy_set_header Host  $host;
            proxy_read_timeout     60;
            proxy_connect_timeout  60;
            proxy_redirect         off;

            # Allow the use of websockets
            proxy_http_version 1.1;
            proxy_set_header Upgrade $http_upgrade;
            proxy_set_header Connection 'upgrade';
            proxy_set_header Host $host;
            proxy_cache_bypass $http_upgrade;
        }
        include /Users/linh/Desktop/Dev/Web/PHP/self-signed.nginx.conf;
        include /Users/linh/Desktop/Dev/Web/PHP/ssl-params.nginx.conf;
}
```

### Trouble
- Clear cookie of `blog-local.com`, `api.blog-local.com`
![image](https://github.com/pnlinh-it/blog-be/assets/11713395/f58e625a-fd7e-49a6-8687-8a3fb423d2ce)

