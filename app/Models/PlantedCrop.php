<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantedCrop extends Model
{
 protected $fillable = [
    'garden_plot_id',
    'type',
    'growth',
    'status',
    'planted_at'
 ];
}
