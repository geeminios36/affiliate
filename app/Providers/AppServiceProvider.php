<?php

namespace App\Providers;

use App\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\BusinessSetting;
use App\Currency;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $tempUserId = getTempUserId();
            $listCart = Cart::where(function ($query) use ($tempUserId) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('temp_user_id', $tempUserId);
                }

            })
                ->with(['product'])
                ->get();

            $view->with('listCart', $listCart);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    // });

  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
  }
}
