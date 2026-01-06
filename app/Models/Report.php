<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $primaryKey = 'id';

    protected $fillable = [
        'property_id',
        'user_id',
        'damage_description',
        'damage_type',
        'ai_analysis',
        'status',
        'reject_reason',
    ];

    protected $casts = [
        'id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class, 'report_id');
    }

    public function getAiAnalysisDataAttribute()
    {
        return json_decode($this->ai_analysis, true);
    }

    public function getDamageTypeDataAttribute(){
        $statusDamage = [
            'partial' => __('menu.partial_damage'),
            'severe_partial' => __('menu.major_partial_damage'),
            'total' => __('menu.total_damage'),
        ];

        $type = $statusDamage[$this->damage_type] ?? 'partial';
        return $type;
    }
}
