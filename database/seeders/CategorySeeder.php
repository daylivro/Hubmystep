<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnerTypes = [
            "Restaurant",
            "Boutique",
            "Magasin",
        ];

        foreach ($partnerTypes as $partnerType) {
            \App\Models\PartnerCategory::create([
                "name" => $partnerType
            ]);
        }

        $rewardCategories = [
            "Miles",
            "Equipements",
            "Reductions",
        ];

        foreach ($rewardCategories as $rewardCategory) {
            \App\Models\RewardCategory::create([
                "name" => $rewardCategory
            ]);
        }


    }
}
