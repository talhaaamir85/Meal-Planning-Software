@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">{{ isset($biometricEntry) ? 'Edit' : 'Add' }} Biometric Entry</h1>

    <form action="{{ isset($biometricEntry) ? route('biometric_entries.update', $biometricEntry->id) : route('biometric_entries.store') }}" method="POST" class="space-y-4">
        @csrf
        @if(isset($biometricEntry))
            @method('PUT')
        @endif

        <div>
            <label>Date:</label>
            <input type="datetime-local" name="recorded_at" value="{{ old('recorded_at', isset($biometricEntry) ? $biometricEntry->recorded_at->format('Y-m-d\TH:i') : '') }}" class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Weight (kg):</label>
            <input type="number" step="any" name="weight_kg" value="{{ old('weight_kg', $biometricEntry->weight_kg ?? '') }}" class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Blood Pressure (Systolic):</label>
            <input type="number" name="blood_pressure_systolic" value="{{ old('blood_pressure_systolic', $biometricEntry->blood_pressure_systolic ?? '') }}" class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Blood Pressure (Diastolic):</label>
            <input type="number" name="blood_pressure_diastolic" value="{{ old('blood_pressure_diastolic', $biometricEntry->blood_pressure_diastolic ?? '') }}" class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Heart Rate:</label>
            <input type="number" name="heart_rate" value="{{ old('heart_rate', $biometricEntry->heart_rate ?? '') }}" class="border px-2 py-1 rounded w-full">
        </div>

        <div>
            <label>Note:</label>
            <textarea name="note" class="border px-2 py-1 rounded w-full">{{ old('note', $biometricEntry->note ?? '') }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">{{ isset($biometricEntry) ? 'Update' : 'Add' }}</button>
    </form>
</div>
@endsection
