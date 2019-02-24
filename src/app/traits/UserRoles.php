<?php

namespace App\Traits;

/**
 * @since 1.0.0
 */
trait UserRoles {

    /**
     * Check if the model instance has a particular role
     *
     * @param  string  $role
     * @return bool
     */
    public function is($role)
    {
        return in_array($role, $this->roles->pluck('name')->all());
    }
}
