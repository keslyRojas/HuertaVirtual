<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantedCrop extends Model
{
    protected $table = 'planted_crops';

    protected $fillable = [
        'garden_plots_id',
        'plants_id',
        'planted_crop_statuses_id',
        'health',
        'last_watered_at',
        'last_fertilized_at',
        'harvested_at',
        'sell_to_market',
    ];

    protected $casts = [
        'last_watered_at'    => 'datetime',
        'last_fertilized_at' => 'datetime',
        'harvested_at'       => 'datetime',
    ];
}
