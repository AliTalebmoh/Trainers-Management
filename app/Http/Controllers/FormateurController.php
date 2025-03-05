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
            $totalAmount = $totalHours * 30.00;
            
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
}
