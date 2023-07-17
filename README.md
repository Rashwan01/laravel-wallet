# Laravel wallet
Light package help you to integrate wallet functionality into your laravel application
## Installation

You can install the package via composer:

```bash
composer require theamostafa/laravel-wallet
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="wallet-migrations"
php artisan migrate
```


## Usage

include **HasWallet** trait into your model to apply wallet functions

```php
use Theamostafa\Wallet\Traits\HasWallet;

class User extends Model {

  use HasWallet;

}
```

Now we make transactions.

```php
$user = User::first();
$user->balance; // 0

$user->deposit(10);
$user->balance; // 10

$user->withdraw(1);
$user->balance; // 9
```
You can also add metadata for transaction

```php
$user = User::first();

$transaction = $user->withdraw(
        amount: 1.33,
        meta: [
            'description' => "Refund from order #14"
        ]
    );
    $transaction->description // Refund from order #14
 
```
Fetch all model transactions.
```php
$user = User::first();

$user->transactions()->latest()->paginate(); 
```
## Testing

```bash
composer test
```
## Credits

- [Ahmed Mostafa](https://github.com/rashwan01)

## Features coming with version 2
-   Model may be having multiple wallet
-   Wallet may be acted as payment gateway and can purchase products 

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
