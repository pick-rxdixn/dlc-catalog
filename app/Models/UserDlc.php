<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDlc extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'dlc_id',
    ];

    protected $casts = [
        'granted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dlc()
    {
        return $this->belongsTo(Dlc::class);
    }
}