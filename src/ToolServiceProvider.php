<?php

namespace JeffersonSimaoGoncalves\MultitenancyNovaTool;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use JeffersonSimaoGoncalves\MultitenancyNovaTool\Policies\PermissionPolicy;
use JeffersonSimaoGoncalves\MultitenancyNovaTool\Policies\RolePolicy;
use JeffersonSimaoGoncalves\MultitenancyNovaTool\Policies\TenantPolicy;
use JeffersonSimaoGoncalves\NovaPermission\Nova\Permission;
use JeffersonSimaoGoncalves\NovaPermission\Nova\Role;
use JeffersonSimaoGoncalves\NovaPermission\NovaPermissionTool;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'multitenancy-tool');

        Nova::serving(function (ServingNova $event) {
            Nova::tools([
                NovaPermissionTool::make()
                    ->rolePolicy(config('multitenancy.policies.role', RolePolicy::class))
                    ->permissionPolicy(config('multitenancy.policies.permission', PermissionPolicy::class))
                    ->roleResource(config('multitenancy.resources.role', Role::class))
                    ->permissionResource(config('multitenancy.resources.permission', Permission::class)),
            ]);
        });

        Gate::policy(config('multitenancy.tenant_model'), TenantPolicy::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
