<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The users that belong to the video.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
