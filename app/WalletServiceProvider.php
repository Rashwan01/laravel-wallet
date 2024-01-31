<?php

namespace Theamostafa\Wallet;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WalletServiceProvider extends PackageServiceProvider {
    public function configurePackage(Package $package): void {
        $package->name('laravel-wallet')
        ->hasMigrations('create_wallet_transactions_table','create_wallets_table');
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
    }
}
