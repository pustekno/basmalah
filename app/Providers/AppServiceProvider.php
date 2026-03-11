<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Listeners\AssignDefaultRole;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Category;
use App\Models\Budget;
use App\Models\Goal;
use App\Policies\TransactionPolicy;
use App\Policies\AccountPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\BudgetPolicy;
use App\Policies\GoalPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Transaction::class => TransactionPolicy::class,
        Account::class => AccountPolicy::class,
        Category::class => CategoryPolicy::class,
        Budget::class => BudgetPolicy::class,
        Goal::class => GoalPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            Registered::class,
            AssignDefaultRole::class,
        );

        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Custom Blade directive for impersonation check
        Blade::if('impersonating', function () {
            return session('is_impersonating') === true;
        });

        Blade::if('notImpersonating', function () {
            return session('is_impersonating') !== true;
        });
    }
}
