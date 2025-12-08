@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">My Biometric Entries</h1>

<a href="{{ route('biometric_entries.create') }}" class="px-4 py-2 bg-green-600 text-white rounded mb-4 inline-block">
    Add New Entry
</a>

<!-- Table of entries -->
<table border="1" cellpadding="5" class="mb-6 w-full">
    <thead>
        <tr>
            <th>Date</th>
            <th>Weight (kg)</th>
            <th>Blood Pressure</th>
            <th>Heart Rate</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <td>{{ $entry->recorded_at }}</td>
            <td>{{ $entry->weight_kg ?? '-' }}</td>
            <td>
                @if($entry->blood_pressure_systolic && $entry->blood_pressure_diastolic)
                    {{ $entry->blood_pressure_systolic }}/{{ $entry->blood_pressure_diastolic }}
                @else
                    -
                @endif
            </td>
            <td>{{ $entry->heart_rate ?? '-' }}</td>
            <td>{{ $entry->note ?? '-' }}</td>
            <td>
                <a href="{{ route('biometric_entries.edit', $entry) }}" class="text-blue-600">Edit</a>
                <form action="{{ route('biometric_entries.destroy', $entry) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Trend Chart -->
<h2 class="text-xl font-bold mb-2">Weight & Blood Pressure Trends</h2>
<canvas id="biometricChart" width="800" height="400"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('biometricChart').getContext('2d');

const data = {
    labels: {!! json_encode($dates) !!},
    datasets: [
        {
            label: 'Weight (kg)',
            data: {!! json_encode($weights) !!},
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            yAxisID: 'y',
            tension: 0.3,
        },
        {
            label: 'Systolic BP',
            data: {!! json_encode($systolic) !!},
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            yAxisID: 'y1',
            tension: 0.3,
        },
        {
            label: 'Diastolic BP',
            data: {!! json_encode($diastolic) !!},
            borderColor: 'rgba(255, 159, 64, 1)',
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            yAxisID: 'y1',
            tension: 0.3,
        }
    ]
};

const config = {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        stacked: false,
        plugins: {
            title: {
                display: true,
                text: 'Biometric Trends Over Time'
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Weight (kg)'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Blood Pressure'
                },
                grid: {
                    drawOnChartArea: false,
                },
            }
        }
    }
};

new Chart(ctx, config);
</script>

@endsection
