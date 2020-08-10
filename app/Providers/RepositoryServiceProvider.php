<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\BookRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Repositories\VirtualCardRepository;



use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\VirtualCardRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(VirtualCardRepositoryInterface::class, VirtualCardRepository::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}