<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */

  public function boot()
  {
    $this->registerPolicies();

    Gate::define('is-factory-people', function ($user) {
      $roles_checked = ['Factory manager', 'Factory employee'];
      if ($user->user_type == 'staff' && in_array($user->staff->role->name, $roles_checked)) {
        return true;
      }
      return false;
    });

    Gate::define('is-factory-employee', function ($user) {
      if ($user->user_type == 'staff' && $user->staff->role->name == 'Factory employee') {
        return true;
      }
      return false;
    });
  }
}
