<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionStatus extends Model
{
    // Disable timestamps since this is a lookup table that doesn't need created_at/updated_at
    public $timestamps = false;
    
    // Allow mass assignment for the name field
    protected $fillable = ['name'];
}
