<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Report;

class PropertyReportSeeder extends Seeder
{
    public function run()
    {
        // ===== تأكد أنه عندنا مستخدم واحد على الأقل =====
        $user = User::first() ?? User::factory()->create();

        $damageTypes = ['partial', 'severe_partial', 'total'];
        $statuses = ['pending', 'rejected', 'approved'];
        $damageStates = ['جزئي', 'كلي', 'جزئي بليغ'];
        $areas = config('areas');
        $properties = [];

        // ===== إنشاء 20 عقار =====
        for ($i = 1; $i <= 20; $i++) {
            $area = $areas[array_rand($areas)];

            $property = Property::create([
                'user_id'        => $user->id,
                'property_owner' => "Owner $i",
                'ownership_type' => ['owned', 'rented'][array_rand(['owned', 'rented'])],
                'address'        => "Street $i, City",
                'latitude'       => rand($area['lat_min']*100000, $area['lat_max']*100000)/100000,
                'longitude'      => rand($area['lng_min']*100000, $area['lng_max']*100000)/100000,
                'floors_count'   => rand(1,5),
                'residents_count'=> rand(1,10),
                'documents'      => null,
            ]);

            $properties[] = $property;
        }

        // ===== إنشاء 20 تقرير مرتبطة بالعقارات =====
        for ($i = 1; $i <= 20; $i++) {
            $property = $properties[array_rand($properties)];

            $percentage = rand(10, 100);
            $state = $damageStates[array_rand($damageStates)];
            $accuracy = rand(5, 30); // نسبة خطأ التقدير %

            Report::create([
                'property_id'       => $property->id,
                'user_id'           => $user->id,
                'damage_description'=> "Damage report $i",
                'damage_type'       => $damageTypes[array_rand($damageTypes)],
                'ai_analysis'       => json_encode([
                    'percentage' => $percentage,
                    'state'      => $state,
                    'accuracy'   => $accuracy
                ], JSON_UNESCAPED_UNICODE),
                'status'            => $statuses[array_rand($statuses)],
                'reject_reason'     => null,
            ]);
        }
    }
}
