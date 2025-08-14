@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Material</h1>
    <form action="{{ route('materials.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Material Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            @error('name') <div class="text-danger"></div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('materials.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection