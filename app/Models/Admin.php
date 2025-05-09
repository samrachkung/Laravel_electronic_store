<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    public function assignRole($role)
    {
        return $this->roles()->syncWithoutDetaching(
            Role::whereName($role)->firstOrFail()
        );
    }

    public function revokeRole($role)
    {
        return $this->roles()->detach(
            Role::whereName($role)->firstOrFail()
        );
    }

    public function hasPermission($permission)
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->contains('name', $permission);
    }
}
