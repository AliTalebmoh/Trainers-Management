<?php

namespace Database\Seeders;

use App\Models\Formateur;
use App\Models\Salary;
use App\Models\Seance;
use Illuminate\Database\Seeder;

class FormateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Formateur 1
        $formateur1 = Formateur::create([
            'name' => 'John Doe',
            'rib' => '230425534323721',
            'name_bank' => 'CIH Bank',
            'matiere' => 'Mathematics'
        ]);

        Salary::create([
            'f_id' => $formateur1->id,
            'price_hour' => 70.00,
            'price_month' => 210.00
        ]);

        for ($i = 1; $i <= 4; $i++) {
            Seance::create([
                'name' => "Session $i",
                'f_id' => $formateur1->id,
                'duration_month' => '02'
            ]);
        }

        // Create Formateur 2
        $formateur2 = Formateur::create([
            'name' => 'Jane Smith',
            'rib' => '230425534323722',
            'name_bank' => 'CIH Bank',
            'matiere' => 'Physics'
        ]);

        Salary::create([
            'f_id' => $formateur2->id,
            'price_hour' => 80.00,
            'price_month' => 240.00
        ]);

        for ($i = 1; $i <= 4; $i++) {
            Seance::create([
                'name' => "Session $i",
                'f_id' => $formateur2->id,
                'duration_month' => '03'
            ]);
        }
    }
}
