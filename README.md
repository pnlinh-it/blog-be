```sh
composer require laravel/breeze --dev
php artisan breeze:install api 
```

```env
APP_URL=http://api.blog-local.com

FRONTEND_URL=http://blog-local.com:3000
# Incase be and fe domain are difference we must specify SESSION_DOMAIN
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

### Trouble
![image](https://github.com/pnlinh-it/blog-be/assets/11713395/f58e625a-fd7e-49a6-8687-8a3fb423d2ce)

