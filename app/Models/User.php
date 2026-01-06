<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'national_id',
        'phone',
        'address',
        'family_members',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function getProfilePhotoUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return $this->avatar;
    }


    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }


    public function reports()
    {
        return $this->hasManyThrough(Report::class, Property::class);
    }

    public function getFirstNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return $parts[0] ?? '';
    }

    public function getSecondNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return $parts[1] ?? '';
    }

    public function getThirdNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return $parts[2] ?? '';
    }

    public function getLastNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return end($parts) ?? '';
    }

    public function getAddressAreaAttribute()
    {
        return explode(' - ', $this->address)[0] ?? '';
    }

    public function getAddressCityAttribute()
    {
        return explode(' - ', $this->address)[1] ?? '';
    }

    public function getAddressStreetAttribute()
    {
        return explode(' - ', $this->address)[2] ?? '';
    }

    public function getAddressDetailsAttribute()
    {
        return explode(' - ', $this->address)[3] ?? '';
    }





}
