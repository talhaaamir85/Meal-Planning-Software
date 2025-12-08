@extends('layouts.app')

@section('content')

<h2 class="mb-4">Profile</h2>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>


{{-- USER BASIC INFO --}}
<div class="card p-4 mb-4">
    <h4>User Information</h4>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
</div>


{{-- UPDATE PROFILE FORM --}}
<div class="card p-4 mb-4">
    @include('profile.partials.update-profile-information-form')
</div>


{{-- UPDATE PASSWORD FORM --}}
<div class="card p-4 mb-4">
    @include('profile.partials.update-password-form')
</div>


{{-- DELETE USER FORM --}}
<div class="card p-4 mb-4">
    @include('profile.partials.delete-user-form')
</div>

@endsection
