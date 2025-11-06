<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStage extends Model
{
    protected $fillable = [
        'production_id',
        'stage_name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
