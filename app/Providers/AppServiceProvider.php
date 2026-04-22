<?php

namespace App\Providers;

use App\Repositories\IRepo\IAuthRepository;
use App\Repositories\IRepo\ICartRepository;
use App\Repositories\IRepo\ICategoryRepository;
use App\Repositories\IRepo\IOrderProductsRepository;
use App\Repositories\IRepo\IOrderRepository;
use App\Repositories\IRepo\IProductRepository;
use App\Repositories\Repo\AuthRepository;
use App\Repositories\Repo\CartRepository;
use App\Repositories\Repo\CategoryRepository;
use App\Repositories\Repo\OrderproductsRepository;
use App\Repositories\Repo\OrderRepository;
use App\Repositories\Repo\ProductRepository;
use App\Services\IService\IAuthService;
use App\Services\IService\ICartService;
use App\Services\IService\ICategoryService;
use App\Services\IService\IOrderProdsService;
use App\Services\IService\IProductService;
use App\Services\Service\AuthService;
use App\Services\Service\CartService;
use App\Services\Service\CategoryService;
use App\Services\Service\OrderProdsService;
use App\Services\Service\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(IAuthRepository::class , AuthRepository::class);
        $this->app->bind(IAuthService::class , AuthService::class);
        //
        $this->app->bind(IProductRepository::class , ProductRepository::class);
        $this->app->bind(IProductService::class , ProductService::class);
        //
        $this->app->bind(ICategoryRepository::class , CategoryRepository::class);
        $this->app->bind(ICategoryService::class , CategoryService::class);
        //
        $this->app->bind(ICartRepository::class , CartRepository::class);
        $this->app->bind(ICartService::class , CartService::class);
        //
        $this->app->bind(IOrderRepository::class , OrderRepository::class);
        //
        $this->app->bind(IOrderProductsRepository::class , OrderproductsRepository::class);
        $this->app->bind(IOrderProdsService::class , OrderProdsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
