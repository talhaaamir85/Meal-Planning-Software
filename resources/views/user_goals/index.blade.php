@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Goals</h1>

    <a href="{{ route('user_goals.create') }}" class="btn btn-primary mb-3">Add New Goal</a>

    @if($goals->count() > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nutrient</th>
                <th>Target</th>
                <th>Unit</th>
                <th>Direction</th>
                <th>Period</th>
                <th>Weight</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($goals as $goal)
            <tr>
                <td>{{ ucfirst($goal->nutrient) }}</td>
                <td>{{ $goal->target_value }}</td>
                <td>{{ $goal->unit ?? '-' }}</td>
                <td>{{ $goal->direction }}</td>
                <td>{{ $goal->period }}</td>
                <td>{{ $goal->weight ?? '-' }}</td>
                <td>{{ $goal->active ? 'Yes' : 'No' }}</td>
                <td>
                    @if($goal->active)
                    <form action="{{ route('user_goals.deactivate', $goal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">Deactivate</button>
                    </form>
                    @else
                    <span class="text-muted">Inactive</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No goals set yet.</p>
    @endif
</div>
@endsection
