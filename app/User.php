<?php

namespace App;
  
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
  
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'password','uuid'
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email','email_verified_at'
    ];


     public function roles() {
        return $this->belongsToMany(Role::class);
    }  

    public function groups() {
        return $this->hasMany(Group::class);
    }

    public function group_users() {
        return $this->hasMany(GroupUser::class);
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles) {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles) {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role) {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function isAdmin() {
       return $this->roles()->where('name', 'admin')->exists();
    }

    public function isUser() {
       return $this->roles()->where('name', 'user')->exists();
    }
}