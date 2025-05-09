<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }
    public function hasPermission($permission)
    {
        return $this->permissions->contains('name', $permission);
    }
    public function assignPermission($permission)
    {
        return $this->permissions()->syncWithoutDetaching(
            Permission::whereName($permission)->firstOrFail()
        );
    }
    public function revokePermission($permission)
    {
        return $this->permissions()->detach(
            Permission::whereName($permission)->firstOrFail()
        );
    }
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->users->contains('name', $role);
        }

        return !!$role->intersect($this->users)->count();
    }
    public function assignRole($role)
    {
        return $this->users()->syncWithoutDetaching(
            User::whereName($role)->firstOrFail()
        );
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo($permission)
    {
        return $this->permissions()->syncWithoutDetaching(
            Permission::whereName($permission)->firstOrFail()
        );
    }

    public function revokePermissionTo($permission)
    {
        return $this->permissions()->detach(
            Permission::whereName($permission)->firstOrFail()
        );
    }
}
