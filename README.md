# Laravel Voteable

Use At Your Own Risk - Not Maintained!

-----

## Installation

First, pull in the package through Composer.

```js
"require": {
    "draperstudio/laravel-voteable": "~1.0"
}
```

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    'DraperStudio\Voteable\VoteableServiceProvider'
];
```

At last you need to publish and run the migration.

```
php artisan vendor:publish && php artisan migrate
```

-----

### Setup a Model
```php
<?php

namespace App;

use DraperStudio\Voteable\Traits\Voteable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Voteable;
}

```

### Sum of all votes
```php
Vote::sum($user);
```

### Count all votes
```php
Vote::count($user);
```

### Count all up-votes
```php
Vote::countUps($user);
```

### Count all down-votes
```php
Vote::countDowns($user);
```

### Count all votes between two dates
```php
Vote::countByDate($user, '2015-06-30', '2015-06-31');
```

### Up-vote
```php
Vote::up($user);
```

### Down-vote
```php
Vote::down($user);
```
