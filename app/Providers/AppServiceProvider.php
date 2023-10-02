<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TodoList;
use App\Observers\ToDoListObserver;
use App\Models\Todo;
use App\Observers\ToDoObserver;

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
      ToDoList::observe(ToDoListObserver::class);
      ToDo::observe(ToDoObserver::class);
    }
}
