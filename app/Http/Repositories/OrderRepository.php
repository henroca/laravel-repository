<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Order;

class OrderRepository extends Base
{
    protected function model()
    {
        return Order::class;
    }

    protected function newQuery()
    {
        $user = Auth::user();

        return parent::newQuery()->where('user_id', $user->id);
    }

    public static function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}
