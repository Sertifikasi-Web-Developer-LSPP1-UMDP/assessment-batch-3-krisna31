<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = auth()->user()->name;
            $query->updated_by = auth()->user()->name;
        });

        static::updating(function ($query) {
            $query->updated_by = auth()->user()->name;
        });
    }
}
