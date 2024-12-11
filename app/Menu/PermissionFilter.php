<?php

namespace App\Menu;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function transform($item)
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        if (isset($item['permission']) && !$user->hasPermission($item['permission'])) {
            return false;
        }

        return $item;
    }
}
