<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'production_id',
        'material_name',
        'quantity',
        'unit',
        'supplier',
        'note',
    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
