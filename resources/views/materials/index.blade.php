@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Material List</h1>
    <a href="{{ route('materials.create') }}" class="btn btn-primary mb-3">Add Material</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Material Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($materials as $material)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $material->name }}</td>
                    <td>
                        <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('materials.destroy', $material->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this material?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No materials found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection