<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'property_owner',
        'ownership_type',
        'address',
        'latitude',
        'longitude',
        'floors_count',
        'residents_count',
        'documents',
    ];

    // 👇 العقار يتبع مستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 👇 كل عقار عنده بلاغ واحد فقط
    public function report()
    {
        return $this->hasOne(Report::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address} ({$this->ownership_type})";
    }

    public function latestReport()
    {
        return $this->hasOne(Report::class)->latestOfMany();
    }
}
