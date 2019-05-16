<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventVenue extends Model
{
    protected $fillable = ['starts_at', 'ends_at', 'status', 'event_id', 'venue_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
