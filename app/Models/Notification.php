<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'created_by',
    ];

    // Users who received this notification
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('is_read');
    }

    // Creator of the notification
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function authUserPivot()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('user_id', Auth::id())
            ->withTimestamps()
            ->withPivot('is_read');
    }
}
