<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = ['name', 'description', 'location', 'capacity', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_venues');
    }
}
