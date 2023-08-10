<?php

namespace App\Providers;

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
    Schema::defaultStringLength(191);
    $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
    if (!empty($business_settings)) {
      $currency = Currency::where('id', $business_settings->value)->first();
      if (empty($currency)) {
        BusinessSetting::where('type', 'system_default_currency')->update(['value' => Currency::where('tenacy_id', get_tenacy_id_for_query())->first()->id]);
      }
    }

    // Event::listen(['eloquent.created: *', 'eloquent.updated: *'], function($model) {
    //   //$model->11111 = 1;
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
