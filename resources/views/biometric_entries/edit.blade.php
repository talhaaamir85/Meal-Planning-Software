@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Biometric Entry</h1>

    <form action="{{ route('biometric_entries.update', $biometricEntry->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label>Date:</label>
            <input type="datetime-local" name="recorded_at" 
                   value="{{ $biometricEntry->recorded_at->format('Y-m-d\TH:i') }}" 
                   class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Weight (kg):</label>
            <input type="number" step="any" name="weight_kg" 
                   value="{{ $biometricEntry->weight_kg }}" 
                   class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Systolic BP:</label>
            <input type="number" name="blood_pressure_systolic" 
                   value="{{ $biometricEntry->blood_pressure_systolic }}" 
                   class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Diastolic BP:</label>
            <input type="number" name="blood_pressure_diastolic" 
                   value="{{ $biometricEntry->blood_pressure_diastolic }}" 
                   class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Heart Rate:</label>
            <input type="number" name="heart_rate" 
                   value="{{ $biometricEntry->heart_rate }}" 
                   class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Note:</label>
            <textarea name="note" class="border px-2 py-1 rounded w-full">{{ $biometricEntry->note }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Update</button>
    </form>
</div>
@endsection
