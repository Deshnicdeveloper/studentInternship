<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Document;
use App\Models\Evaluation;
use App\Models\Logbook;
use App\Models\Placement;
use App\Policies\ApplicationPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\LogbookPolicy;
use App\Policies\PlacementPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        // Register policies
        Gate::policy(Application::class, ApplicationPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(Evaluation::class, EvaluationPolicy::class);
        Gate::policy(Logbook::class, LogbookPolicy::class);
        Gate::policy(Placement::class, PlacementPolicy::class);
    }
}
