<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{

    protected $table = 'notification_types';

    protected $fillable = [
        'name',
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'notification_types_id');
    }

}
