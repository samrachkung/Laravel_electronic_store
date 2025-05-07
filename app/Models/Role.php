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
