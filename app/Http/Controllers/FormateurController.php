<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\Seance;
use App\Models\Salary;
use App\Exports\FormularExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormateurController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', 2);
        $formateurs = Formateur::with(['seances' => function($query) use ($month) {
            $query->where('duration_month', $month);
        }, 'salary'])->get();

        // Calculate totals for the selected month
        foreach ($formateurs as $formateur) {
            $totalHours = $formateur->seances->sum('duration');
            $totalAmount = $totalHours * $formateur->salary->price_per_hour;
            
            // Update or create salary record for this month
            $formateur->salary->update([
                'total_hours' => $totalHours,
                'total_amount' => $totalAmount
            ]);
        }

        return view('formateurs.index', compact('formateurs'));
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
        $formateur = Formateur::findOrFail($formateur_id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjects' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'total_hours' => 'required|numeric|min:0',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|numeric|min:0'
        ]);

        // Update trainer basic info
        $formateur->update([
            'name' => $validated['name'],
            'subjects' => $validated['subjects'],
            'bank_account' => $validated['bank_account'],
            'bank_name' => $validated['bank_name']
        ]);

        // Update salary info and calculate new total amount
        $formateur->salary->update([
            'price_per_hour' => $validated['price_per_hour'],
            'total_amount' => $validated['total_hours'] * $validated['price_per_hour']
        ]);

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
}
