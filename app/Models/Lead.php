<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'assigned_user_id',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function notes()
    {
        return $this->hasMany(LeadNote::class);
    }

    public function latestNote()
    {
        return $this->hasOne(LeadNote::class)->latestOfMany();
    }
}
