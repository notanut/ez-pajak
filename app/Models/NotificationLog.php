<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationLog;

class NotificationLog extends Model
{
    //
    protected $fillable = [
        'pengguna_id',
        'notification_type',
        'email',
        'scheduled_at',
    ];
}
