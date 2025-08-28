<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => '有料老人ホーム'],
            ['name' => 'グループホーム'],
            ['name' => 'デイサービスセンター'],
            ['name' => '訪問看護ステーション'],
            ['name' => 'ヘルパーステーション'],
            ['name' => 'ケアプランセンター'],
            ['name' => '他（事務所など）'],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate($department);
        }
    }
}