<?php

namespace App\Support;

use DsApps\LaravelCrm\Contracts\AuthorizationResolver;
use Illuminate\Contracts\Auth\Authenticatable;

final class CrmAuthorizationResolver implements AuthorizationResolver
{
    public function can(Authenticatable $user, string $ability, mixed $resource = null): bool
    {
        return config('crm.demo.enabled')
            || (method_exists($user, 'hasPermission') && $user->hasPermission($ability));
    }
}
