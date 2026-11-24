<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dlc extends Model
{
    protected $fillable = [
        'game_id',
        'category_id',
        'title',
        'description',
        'image',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class, 'user_dlcs'
        )->withPivot('granted_at');
    }
}
