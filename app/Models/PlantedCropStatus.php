<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantedCropStatus extends Model
{
    protected $table = 'planted_crop_statuses';

    protected $fillable = [
        'status'
    ];
}
