@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $facility->business_name }}</h1>
    <p><strong>Last Update:</strong> {{ $facility->last_update_date }}</p>
    <p><strong>Address:</strong> {{ $facility->street_address }}</p>
    <p><strong>Materials Accepted:</strong> {{ $facility->materials->pluck('name')->join(', ') }}</p>

    <h3>Location</h3>
    <iframe 
        src="https://www.google.com/maps?q={{ urlencode($facility->street_address) }}&output=embed"
        width="100%" height="400" style="border:0;" allowfullscreen>
    </iframe>

    <a href="{{ route('facilities.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
