@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Facility</h1>

    <form action="{{ route('facilities.update', $facility) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="business_name" class="form-label">Business Name</label>
            <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $facility->business_name) }}" class="form-control" required>
            @error('business_name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="last_update_date" class="form-label">Last Update Date</label>
            <input type="date" name="last_update_date" id="last_update_date" value="{{ old('last_update_date', $facility->last_update_date) }}" class="form-control" required>
            @error('last_update_date') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="street_address" class="form-label">Street Address</label>
            <textarea name="street_address" id="street_address" class="form-control" required>{{ old('street_address', $facility->street_address) }}</textarea>
            @error('street_address') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Materials Accepted</label>
            <div>
                @foreach($materials as $material)
                    <div class="col-md-4">
                        <input class="form-check-input" type="checkbox" name="materials[]" id="material_{{ $material->id }}" value="{{ $material->id }}"
                            {{ (is_array(old('materials')) && in_array($material->id, old('materials'))) || (!old('materials') && $facility->materials->contains($material->id)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="material_{{ $material->id }}">{{ $material->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('materials') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('facilities.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
