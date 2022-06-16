<?php

namespace App\Providers;

use App\Repositories\GameRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\GameService;
use App\Services\GameServiceInterface;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(GameServiceInterface::class, GameService::class);
        $this->app->when(GameRepository::class)
            ->needs(Model::class)
            ->give(function() { 
                return new Game;
            });
    }
}
