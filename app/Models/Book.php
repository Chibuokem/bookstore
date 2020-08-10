<?php

namespace App\Models;

use App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}