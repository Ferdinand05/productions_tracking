<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'customer_id',
        'production_code',
        'product_name',
        'description',
        'start_date',
        'estimated_end_date',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function stages()
    {
        return $this->hasMany(ProductionStage::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
