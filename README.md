# Admin Panel for Laravel 5 #

## ***Install:*** ##

Composer:

```json

"cinject/admin-panel": "dev-master"
```

Providers:

```PHP

'Zizaco\Entrust\EntrustServiceProvider',
'Cinject\AdminPanel\Providers\AdminPanelServiceProvider',
```

Aliases:

```PHP
'Entrust'  =>  'Zizaco\Entrust\EntrustFacade',
```

Publish resource:

```bash
php artisan vendor:publish --provider='Cinject\AdminPanel\Providers\AdminPanelServiceProvider'
```

***tags:*** assets, config
