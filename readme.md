
<!-- [title](https://www.example.com)
> blockquote -->

<!-- *italicized text*
**bold text** -->

## Installation

> composer require bytecraftnz/supabasePHP

### Laravel
In the **Providers.php** file, which can be found in the bootstap folder add the following
```
<?php

return [
    ...
    \Bytecraftnz\SupabasePhp\Laravel\SupavalServiceProvider::class,
];

```
Now we can publish the configuration.
```
php artisan vendor:publish --tag=supaval 
```

#### AuthProvider


## AuthClient

```
// @returns Bytecraftnz\SupabasePhp\Contract\AuthClient
$authClient = Bytecraftnz\SupabasePhp\Supabase::createAuthClient(string $url, string $key);
```
> $key is your anon key

## AdminClient

```
// @returns Bytecraftnz\SupabasePhp\Contract\AuthClient
$authClient = Bytecraftnz\SupabasePhp\Supabase::createAdminClient(string $url, string $key, string $serviceRoleKey);
```
> $key is your anon key
>
> $serviceRoleKey is your Service Role Key - PLEASE DONT EXPOSE TO PUBLIC


