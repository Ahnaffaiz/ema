<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected $casts = [
        'registration_start_date' => 'datetime',
        'registration_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'require_approval' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function eventTickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function eventCheckins()
    {
        return $this->hasManyThrough(EventCheckin::class, EventTicket::class);
    }

    // Location helper methods
    public function isPhysicalLocation()
    {
        return $this->location_type === 'physical';
    }

    public function isVirtualLocation()
    {
        return $this->location_type === 'virtual';
    }

    public function getLocationDisplayAttribute()
    {
        if ($this->isVirtualLocation()) {
            return 'Virtual Event';
        }

        return $this->location_address ?: 'Location TBD';
    }
}
