<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\Seance;
use App\Models\Salary;
use App\Exports\FormularExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class FormateurController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', 2);
        $formateurs = Formateur::with(['seances' => function($query) use ($month) {
            $query->where('duration_month', $month);
        }, 'salary'])->get();

        // We're no longer automatically calculating totals here
        // This ensures that manually set total_hours values are preserved

        return view('formateurs.index', compact('formateurs'));
    }

    public function create()
    {
        return view('formateurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'bank_account' => 'required|string|size:24',
            'bank_name' => 'required|string|max:255',
            'month' => 'required|integer|min:1|max:12',
            'price_per_hour' => 'required|numeric|min:0',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|numeric|min:0',
            'session_days' => 'required|array|min:1',
            'session_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        // Create new formateur
        $formateur = Formateur::create([
            'name' => $validated['name'],
            'subjects' => $validated['subjects'],
            'bank_account' => $validated['bank_account'],
            'bank_name' => $validated['bank_name'],
        ]);

        // Calculate total hours and amount
        $totalHours = $validated['duration'] * count($validated['session_days']) * 4; // Assuming 4 weeks per month
        $totalAmount = $totalHours * $validated['price_per_hour'];

        // Create salary record
        Salary::create([
            'formateur_id' => $formateur->id,
            'price_per_hour' => $validated['price_per_hour'],
            'total_hours' => $totalHours,
            'total_amount' => $totalAmount,
        ]);

        // Create sessions for the month
        $month = $validated['month'];
        $year = 2025; // Hardcoded for now, could be dynamic

        // Get all dates for the selected days in the month
        $dates = $this->getDatesForMonth($month, $year, $validated['session_days']);

        foreach ($dates as $date) {
            Seance::create([
                'formateur_id' => $formateur->id,
                'date' => $date,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'duration' => $validated['duration'],
                'price_per_hour' => $validated['price_per_hour'],
                'duration_month' => $month,
            ]);
        }

        return redirect()->route('formateur.index')->with('success', 'Trainer added successfully!');
    }

    /**
     * Get all dates for the selected days in a month
     */
    private function getDatesForMonth($month, $year, $days)
    {
        $dates = [];
        $daysMap = [
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
            'sunday' => 0,
        ];

        // Get the number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Loop through each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = \Carbon\Carbon::createFromDate($year, $month, $day);
            $dayOfWeek = $date->dayOfWeek; // 0 (Sunday) to 6 (Saturday)

            // Check if this day of the week is in the selected days
            foreach ($days as $selectedDay) {
                if ($dayOfWeek === $daysMap[$selectedDay]) {
                    $dates[] = $date->format('Y-m-d');
                    break;
                }
            }
        }

        return $dates;
    }

    public function getFormateurDetails(Request $request)
    {
        $formateur = Formateur::with(['seances' => function($query) use ($request) {
            $query->where('duration_month', $request->month);
        }, 'salary'])->findOrFail($request->formateur_id);

        $seances = $formateur->seances;
        $salary = $formateur->salary;
        
        return view('formateurs.details', compact('formateur', 'seances', 'salary'));
    }

    public function downloadFormular(Request $request)
    {
        $formateur = Formateur::with(['seances' => function($query) use ($request) {
            $query->where('duration_month', $request->month);
        }, 'salary'])->findOrFail($request->formateur_id);

        $seances = $formateur->seances;
        $export = new FormularExport($formateur, $seances, $request->month);
        $filename = $export->export();

        return response()->download(storage_path('app/public/' . $filename))->deleteFileAfterSend();
    }

    public function edit($formateur_id)
    {
        $formateur = Formateur::with(['seances', 'salary'])->findOrFail($formateur_id);

        // Get the first month's data as template
        $monthlyData = $formateur->seances
            ->groupBy('duration_month')
            ->map(function ($sessions) {
                return [
                    'total_hours' => $sessions->sum('duration'),
                    'typical_start_time' => $sessions->first()->start_time->format('H:i'),
                    'typical_end_time' => $sessions->first()->end_time->format('H:i'),
                    'typical_duration' => $sessions->first()->duration
                ];
            })
            ->first();
        
        return view('formateurs.edit', compact('formateur', 'monthlyData'));
    }

    public function update(Request $request, $formateur_id)
    {
        $formateur = Formateur::with('salary')->findOrFail($formateur_id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'total_hours' => 'required|numeric|min:0',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|numeric|min:0',
            'session_days' => 'required|array|min:1',
            'session_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        // Update trainer basic info
        $formateur->update([
            'name' => $validated['name'],
            'subjects' => $validated['subjects'],
            'bank_account' => $validated['bank_account'],
            'bank_name' => $validated['bank_name']
        ]);

        // Explicitly set the total hours and calculate the new total amount
        $totalHours = $validated['total_hours'];
        $totalAmount = $totalHours * $validated['price_per_hour'];

        // Update salary info with the new values
        $formateur->salary->total_hours = $totalHours;
        $formateur->salary->price_per_hour = $validated['price_per_hour'];
        $formateur->salary->total_amount = $totalAmount;
        $formateur->salary->save();

        // Store the session days in the formateur's metadata
        $formateur->session_days = $validated['session_days'];
        $formateur->save();

        // Update all sessions with the new times, hours, and price
        $sessionsPerMonth = $formateur->seances->groupBy('duration_month');
        foreach ($sessionsPerMonth as $month => $sessions) {
            $sessionsCount = $sessions->count();
            if ($sessionsCount > 0) {
                Seance::where('formateur_id', $formateur->id)
                    ->where('duration_month', $month)
                    ->update([
                        'start_time' => $validated['start_time'],
                        'end_time' => $validated['end_time'],
                        'duration' => $validated['duration'],
                        'price_per_hour' => $validated['price_per_hour']
                    ]);
            }
        }

        return redirect()->route('formateur.index')
            ->with('success', 'Trainer information updated successfully for all months');
    }

    /**
     * Show the form for editing a specific session.
     */
    public function editSession($session_id)
    {
        $session = Seance::findOrFail($session_id);
        $formateur = $session->formateur;
        
        return view('formateurs.edit_session', compact('session', 'formateur'));
    }

    /**
     * Update a specific session.
     */
    public function updateSession(Request $request, $session_id)
    {
        $session = Seance::findOrFail($session_id);
        
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|numeric|min:0',
            'price_per_hour' => 'required|numeric|min:0'
        ]);

        // Update the session
        $session->update([
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration' => $validated['duration'],
            'price_per_hour' => $validated['price_per_hour']
        ]);

        // Recalculate the total hours and amount for the trainer's salary
        $formateur = $session->formateur;
        $month = $session->duration_month;
        
        $totalHours = $formateur->seances()
            ->where('duration_month', $month)
            ->sum('duration');
            
        $totalAmount = $formateur->seances()
            ->where('duration_month', $month)
            ->sum(\DB::raw('duration * price_per_hour'));

        // Update the salary record
        $formateur->salary->update([
            'total_hours' => $totalHours,
            'total_amount' => $totalAmount
        ]);

        return redirect()->route('formateur.details', [
            'formateur_id' => $session->formateur_id,
            'month' => $session->duration_month
        ])->with('success', 'Session updated successfully');
    }

    /**
     * Delete a specific session.
     */
    public function deleteSession($session_id)
    {
        $session = Seance::findOrFail($session_id);
        
        // Store formateur and month info before deleting
        $formateur_id = $session->formateur_id;
        $month = $session->duration_month;
        $formateur = $session->formateur;
        
        // Delete the session
        $session->delete();
        
        // Recalculate the total hours and amount for the trainer's salary
        $totalHours = $formateur->seances()
            ->where('duration_month', $month)
            ->sum('duration');
            
        $totalAmount = $formateur->seances()
            ->where('duration_month', $month)
            ->sum(\DB::raw('duration * price_per_hour'));

        // Update the salary record
        $formateur->salary->update([
            'total_hours' => $totalHours,
            'total_amount' => $totalAmount
        ]);

        return redirect()->route('formateur.details', [
            'formateur_id' => $formateur_id,
            'month' => $month
        ])->with('success', 'Session deleted successfully');
    }
}
