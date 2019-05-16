<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'type', 'priority', 'frequency'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function venues()
    {
        return $this->belongsToMany(Venue::class, 'event_venues');
    }
}
