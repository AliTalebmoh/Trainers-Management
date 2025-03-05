<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formateur;
use App\Models\Seance;
use App\Models\Salary;

class TrainerSeeder extends Seeder
{
    public function run()
    {
        // Create trainers
        $trainers = [
            [
                'name' => 'AIT KHELLOU Samira',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'BOURZAMA Zakia',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'ZIZOUNE Fatima',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'SAFI Milouda',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'EL OUARGUI Lhoussaine',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'ABARAOU Moha',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'EL BACHIRI Mouhcine',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'QAIDI Ali',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'MOUFADDAL Mohamed',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'EL AAHED Fatima-Zohra',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'BOUZIANE Mouna',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'BENBRA Samir',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'BARIQI ALAOUI Khadija',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
            [
                'name' => 'HABRANE Hassane',
                'bank_account' => '230 425 534 323 721 1020400 40',
                'subjects' => 'Formation continue'
            ],
        ];

        foreach ($trainers as $trainer) {
            $formateur = Formateur::create($trainer);
            
            // Create initial salary record for each trainer
            Salary::create([
                'formateur_id' => $formateur->id,
                'price_per_hour' => 30.00,
                'total_hours' => 0,
                'total_amount' => 0
            ]);
        }

        // Create seances for each trainer
        $this->createSeances();

        // Update salary totals based on seances
        $this->updateSalaryTotals();
    }

    private function updateSalaryTotals()
    {
        $formateurs = Formateur::with('seances')->get();

        foreach ($formateurs as $formateur) {
            $totalHours = $formateur->seances->sum('duration');
            $totalAmount = $totalHours * 30.00; // 30 DH per hour

            Salary::where('formateur_id', $formateur->id)->update([
                'total_hours' => $totalHours,
                'total_amount' => $totalAmount
            ]);
        }
    }

    private function createSeances()
    {
        $schedule = [
            'AIT KHELLOU Samira' => [
                ['day' => 'Mardi', 'start_time' => '09:30', 'end_time' => '12:30'],
                ['day' => 'Mercredi', 'start_time' => '09:30', 'end_time' => '12:30'],
                ['day' => 'Jeudi', 'start_time' => '09:30', 'end_time' => '12:30'],
            ],
            'BOURZAMA Zakia' => [
                ['day' => 'Lundi', 'start_time' => '15:00', 'end_time' => '18:00'],
                ['day' => 'Mardi', 'start_time' => '15:00', 'end_time' => '18:00'],
                ['day' => 'Mercredi', 'start_time' => '15:00', 'end_time' => '18:00'],
            ],
            'ZIZOUNE Fatima' => [
                ['day' => 'Lundi', 'start_time' => '09:30', 'end_time' => '12:30'],
                ['day' => 'Jeudi', 'start_time' => '15:00', 'end_time' => '18:00'],
            ],
            'SAFI Milouda' => [
                ['day' => 'Lundi', 'start_time' => '09:00', 'end_time' => '12:00'],
                ['day' => 'Lundi', 'start_time' => '15:00', 'end_time' => '17:00'],
                ['day' => 'Mardi', 'start_time' => '09:00', 'end_time' => '11:00'],
                ['day' => 'Mardi', 'start_time' => '14:00', 'end_time' => '17:00'],
                ['day' => 'Mercredi', 'start_time' => '09:00', 'end_time' => '12:00'],
            ],
            'EL OUARGUI Lhoussaine' => [
                ['day' => 'Lundi', 'start_time' => '09:30', 'end_time' => '13:00'],
                ['day' => 'Lundi', 'start_time' => '14:00', 'end_time' => '17:00'],
                ['day' => 'Mardi', 'start_time' => '09:00', 'end_time' => '13:00'],
            ],
            'EL BACHIRI Mouhcine' => [
                ['day' => 'Mardi', 'start_time' => '10:00', 'end_time' => '12:00'],
                ['day' => 'Mardi', 'start_time' => '14:00', 'end_time' => '16:00'],
                ['day' => 'Mardi', 'start_time' => '16:00', 'end_time' => '18:00'],
            ],
            'QAIDI Ali' => [
                ['day' => 'Mercredi', 'start_time' => '14:00', 'end_time' => '16:00'],
                ['day' => 'Mercredi', 'start_time' => '16:00', 'end_time' => '18:00'],
                ['day' => 'Jeudi', 'start_time' => '09:00', 'end_time' => '10:30'],
                ['day' => 'Jeudi', 'start_time' => '10:30', 'end_time' => '12:00'],
            ],
            'MOUFADDAL Mohamed' => [
                ['day' => 'Lundi', 'start_time' => '09:00', 'end_time' => '13:00'],
                ['day' => 'Mardi', 'start_time' => '09:00', 'end_time' => '12:00'],
                ['day' => 'Jeudi', 'start_time' => '09:00', 'end_time' => '12:00'],
            ],
            'EL AAHED Fatima-Zohra' => [
                ['day' => 'Vendredi', 'start_time' => '09:00', 'end_time' => '12:00'],
                ['day' => 'Samedi', 'start_time' => '09:00', 'end_time' => '13:00'],
            ],
            'ABARAOU Moha' => [
                ['day' => 'Vendredi', 'start_time' => '09:00', 'end_time' => '13:00'],
                ['day' => 'Vendredi', 'start_time' => '14:30', 'end_time' => '18:30'],
            ],
            'BOUZIANE Mouna' => [
                ['day' => 'Mercredi', 'start_time' => '14:00', 'end_time' => '15:30'],
                ['day' => 'Mercredi', 'start_time' => '15:30', 'end_time' => '17:00'],
                ['day' => 'Mercredi', 'start_time' => '10:00', 'end_time' => '12:00'],
                ['day' => 'Jeudi', 'start_time' => '14:00', 'end_time' => '16:00'],
            ],
            'BENBRA Samir' => [
                ['day' => 'Mardi', 'start_time' => '15:00', 'end_time' => '18:00'],
                ['day' => 'Jeudi', 'start_time' => '15:00', 'end_time' => '18:00'],
            ],
            'BARIQI ALAOUI Khadija' => [
                ['day' => 'Lundi', 'start_time' => '09:00', 'end_time' => '13:00'],
                ['day' => 'Mardi', 'start_time' => '09:00', 'end_time' => '13:00'],
                ['day' => 'Mercredi', 'start_time' => '09:00', 'end_time' => '13:00'],
                ['day' => 'Jeudi', 'start_time' => '09:00', 'end_time' => '12:00'],
            ],
            'HABRANE Hassane' => [
                ['day' => 'Lundi', 'start_time' => '10:00', 'end_time' => '14:00'],
                ['day' => 'Vendredi', 'start_time' => '10:00', 'end_time' => '14:00'],
            ],
        ];

        foreach ($schedule as $trainerName => $sessions) {
            $trainer = Formateur::where('name', $trainerName)->first();
            if (!$trainer) continue;

            // Create sessions for each month of 2025
            for ($month = 1; $month <= 12; $month++) {
                foreach ($sessions as $session) {
                    // Calculate dates for the current month in 2025
                    $dates = $this->getDatesForMonth($session['day'], $month);
                    
                    foreach ($dates as $date) {
                        // Calculate duration in hours
                        $start = strtotime($session['start_time']);
                        $end = strtotime($session['end_time']);
                        $duration = ($end - $start) / 3600;

                        Seance::create([
                            'formateur_id' => $trainer->id,
                            'date' => $date,
                            'start_time' => $session['start_time'],
                            'end_time' => $session['end_time'],
                            'duration' => $duration,
                            'price_per_hour' => 30,
                            'duration_month' => $month,
                        ]);
                    }
                }
            }
        }
    }

    private function getDatesForMonth($dayName, $month)
    {
        $dates = [];
        $year = 2025;
        $start = strtotime("$year-$month-01");
        $end = strtotime(date('Y-m-t', $start));
        
        $dayMap = [
            'Lundi' => 'Monday',
            'Mardi' => 'Tuesday',
            'Mercredi' => 'Wednesday',
            'Jeudi' => 'Thursday',
            'Vendredi' => 'Friday',
            'Samedi' => 'Saturday',
            'Dimanche' => 'Sunday'
        ];
        
        $englishDayName = $dayMap[$dayName];
        
        for ($date = $start; $date <= $end; $date = strtotime('+1 day', $date)) {
            if (date('l', $date) === $englishDayName) {
                $dates[] = date('Y-m-d', $date);
            }
        }
        
        return $dates;
    }
} 