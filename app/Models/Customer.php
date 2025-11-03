<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_code',
        'name',
        'phone',
        'address',
        'note',
    ];

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
