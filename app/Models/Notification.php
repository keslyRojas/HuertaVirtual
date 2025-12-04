<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   protected $table = 'notifications';

    protected $fillable = [
        'notification_types_id',
        'user_id',
        'title',
        'content',
        'is_read',
    ];

    public function type()
    {
        return $this->belongsTo(NotificationType::class, 'notification_types_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
