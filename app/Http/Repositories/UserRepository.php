<?php

namespace App\Http\Repositories;

use App\User;

class UserRepository extends Base
{
    protected function model()
    {
        return User::class;
    }

    public static function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public static function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
