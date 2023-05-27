# LEARN

Install laravel

# Install sanctum 
ini sudah terpasang harusnya karena bawaan laravel


# JWT

## Install jwt

```
composer require php-open-source-saver/jwt-auth
```

publicasi provider agar bisa d gunakan d project dan ada file config/jwt.php

```
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

kemudian generate key untuk jwt yg akan tersimpan di .env

```
php artisan jwt:secret
```

## Setting authguard
Buka `/config/auth.php`

```
...
'defaults' => [
    'guard' => 'web',  // ganti jadi api
    'passwords' => 'users',
],
```

kemudian buat api array pada guard
```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [                          // buat manual
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

Masuk ke `/app/Models/Users.php` lalu buang sanctum

```php
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;                      // hapus atau coment
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;      // tambahkan package JWT

class User extends Authenticatable implements JWTSubject  // tambahkan implement JWT
```

Buang `HasApiTokens` milik si sanctum sehingga menadi: 

```php
use HasFactory, Notifiable;
```

baris paling bawah sebelum class ditutup tambahkan identifier jwt

```php
// tambahkan identifier jwt dan claims
public function getJWTIdentifier()
{
    return $this->getKey();
}

public function getJWTCustomClaims()
{
    return [];
}
```

**Lakukan migrate agar file migrations masuk ke db**
```
php artisan migrate
```

# Buat file controller (ingat ini API maka simpan dalam folder Apis)

Buat folder `/app/Http/Controllers/Apis`

```
php artisan make:controller Apis/AuthController
```

tambahkan Facades Auth dan Facades Hash dan tambahkan model user

```php
<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;        // tambahkan untuk ambil login, logout, user actif dll
use Illuminate\Support\Facades\Hash;        // tambahkan hash password
use Illuminate\Support\Facades\Validator;   // tambahkan untuk validasi request
use App\Models\User;                        // tambah model user

class AuthController extends Controller
{
    // register
    public function register(Request $request)
    {

    }
}
```

