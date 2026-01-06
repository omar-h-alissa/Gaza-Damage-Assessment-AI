<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'icon',
    ];

    /**
     * النشاط تابع لمستخدم واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * اختصار لإرجاع لون البادج حسب النوع
     */
    public function getBadgeColorAttribute()
    {
        return [
            'success' => 'badge-light-success',
            'danger'  => 'badge-light-danger',
            'warning' => 'badge-light-warning',
            'info'    => 'badge-light-info',
        ][$this->type] ?? 'badge-light-secondary';
    }
}
