@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recycling Facilities</h1>

    <form method="GET" action="{{ route('facilities.index') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search by name, address, or material" value="{{ request('search') }}">
        
        <select name="material_id" class="form-select">
            <option value="">All Materials</option>
            @foreach($materials as $material)
                <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>
                    {{ $material->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="form-select">
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Last Updated Desc</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Last Updated Asc</option>
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('facilities.export', request()->all()) }}" class="btn btn-success">Export CSV</a>
        <a href="{{ route('facilities.create') }}" class="btn btn-info">Add Facility</a>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Business Name</th>
                <th>Last Updated</th>
                <th>Address</th>
                <th>Materials Accepted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facilities as $facility)
                <tr>
                    <td>{{ $facility->business_name }}</td>
                    <td>{{ $facility->last_update_date }}</td>
                    <td>{{ $facility->street_address }}</td>
                    <td>{{ $facility->materials->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('facilities.show', $facility) }}" class="btn btn-sm btn-primary" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('facilities.edit', $facility) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('facilities.destroy', $facility) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this facility?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No facilities found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $facilities->links() }}
</div>
@endsection
