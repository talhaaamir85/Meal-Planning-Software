<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiometricEntry;
use Illuminate\Support\Facades\Auth;

class BiometricEntryController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Get all entries in ascending order (oldest first) for trend chart
    $entries = $user->biometrics()->orderBy('recorded_at')->get();

    // Prepare data for chart
    $dates = $entries->pluck('recorded_at')->map(fn($d) => $d->format('Y-m-d'))->toArray();
    $weights = $entries->pluck('weight_kg')->toArray();
    $systolic = $entries->pluck('blood_pressure_systolic')->toArray();
    $diastolic = $entries->pluck('blood_pressure_diastolic')->toArray();

    return view('biometric_entries.index', compact('entries', 'dates', 'weights', 'systolic', 'diastolic'));
}


    public function create()
    {
        return view('biometric_entries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'recorded_at' => 'required|date',
            'weight_kg' => 'nullable|numeric|min:0',
            'blood_pressure_systolic' => 'nullable|integer|min:0',
            'blood_pressure_diastolic' => 'nullable|integer|min:0',
            'heart_rate' => 'nullable|integer|min:0',
            'note' => 'nullable|string',
        ]);

        BiometricEntry::create([
            'user_id' => Auth::id(),
            'recorded_at' => $request->recorded_at,
            'weight_kg' => $request->weight_kg,
            'blood_pressure_systolic' => $request->blood_pressure_systolic,
            'blood_pressure_diastolic' => $request->blood_pressure_diastolic,
            'heart_rate' => $request->heart_rate,
            'note' => $request->note,
        ]);

        return redirect()->route('biometric_entries.index')->with('success', 'Biometric entry added!');
    }

    public function edit(BiometricEntry $biometricEntry)
    {
        $this->authorizeEntry($biometricEntry);
        return view('biometric_entries.edit', compact('biometricEntry'));
    }

    public function update(Request $request, BiometricEntry $biometricEntry)
    {
        $this->authorizeEntry($biometricEntry);

        $request->validate([
            'recorded_at' => 'required|date',
            'weight_kg' => 'nullable|numeric|min:0',
            'blood_pressure_systolic' => 'nullable|integer|min:0',
            'blood_pressure_diastolic' => 'nullable|integer|min:0',
            'heart_rate' => 'nullable|integer|min:0',
            'note' => 'nullable|string',
        ]);

        $biometricEntry->update($request->all());

        return redirect()->route('biometric_entries.index')->with('success', 'Entry updated!');
    }

    public function destroy(BiometricEntry $biometricEntry)
    {
        $this->authorizeEntry($biometricEntry);
        $biometricEntry->delete();

        return redirect()->route('biometric_entries.index')->with('success', 'Entry deleted!');
    }

    private function authorizeEntry(BiometricEntry $entry)
    {
        if ($entry->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
