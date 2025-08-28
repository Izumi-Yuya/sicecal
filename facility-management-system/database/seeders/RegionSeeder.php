<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Department;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get department IDs
        $facilityDept = Department::where('name', '有料老人ホーム')->first();
        $dayServiceDept = Department::where('name', 'デイサービスセンター')->first();
        $carePlanDept = Department::where('name', 'ケアプランセンター')->first();

        $regions = [
            // 有料老人ホーム地区
            ['name' => '東日本', 'department_id' => $facilityDept?->id],
            ['name' => '西日本', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当A', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当B', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当C', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当D', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当E', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当F', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当G', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当H', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当I', 'department_id' => $facilityDept?->id],
            ['name' => '地区担当J', 'department_id' => $facilityDept?->id],
            
            // デイサービス地区
            ['name' => 'デイ東日本', 'department_id' => $dayServiceDept?->id],
            ['name' => 'デイ西日本', 'department_id' => $dayServiceDept?->id],
            
            // ケアプラン地区
            ['name' => 'ケア東日本', 'department_id' => $carePlanDept?->id],
            ['name' => 'ケア西日本', 'department_id' => $carePlanDept?->id],
        ];

        foreach ($regions as $region) {
            if ($region['department_id']) {
                Region::firstOrCreate($region);
            }
        }
    }
}