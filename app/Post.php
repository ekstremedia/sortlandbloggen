<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Add relation to User model
    // Post belongs to User
    // Foreign key 'user_id' on Post table
    public function author()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
