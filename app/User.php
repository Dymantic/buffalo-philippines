<?php

namespace App;

use Dymantic\Articles\AuthorsArticles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, AuthorsArticles;


    protected $fillable = [
        'name',
        'email',
        'password',
        'superadmin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = ['superadmin' => 'boolean'];

    public static function register($user_attributes)
    {
        $user_attributes['password'] = bcrypt($user_attributes['password']);
        return static::create($user_attributes);
    }

    public function resetPassword($password)
    {
        $this->password = bcrypt($password);
        $this->save();
    }

    public function toJsonableArray()
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'superadmin' => $this->superadmin
        ];
    }

    public function promoteToSuperAdmin()
    {
        $this->superadmin = true;
        return $this->save();
    }

    public function demoteToRegularUser()
    {
        $this->superadmin = false;
        return $this->save();
    }
}
