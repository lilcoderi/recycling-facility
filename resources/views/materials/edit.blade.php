@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Material</h1>
    <form action="{{ route('materials.update', $material->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Material Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $material->name) }}">
            @error('name') <div class="text-danger"></div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('materials.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection