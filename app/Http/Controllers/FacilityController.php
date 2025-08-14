<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Material;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of facilities with pagination, search, sort, and filter.
     */
    public function index(Request $request)
    {
        $query = Facility::with('materials');

        // Search by business name, street address, or material name
        if ($search = $request->input('search')) {
            $query->where('business_name', 'like', "%{$search}%")
                  ->orWhere('street_address', 'like', "%{$search}%")
                  ->orWhereHas('materials', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        // Filter by material
        if ($materialId = $request->input('material_id')) {
            $query->whereHas('materials', function ($q) use ($materialId) {
                $q->where('materials.id', $materialId);
            });
        }

        // Sort by last update date
        if ($sort = $request->input('sort')) {
            $query->orderBy('last_update_date', $sort);
        } else {
            $query->orderBy('last_update_date', 'desc');
        }

        $facilities = $query->paginate(10);
        $materials = Material::all();

        return view('facilities.index', compact('facilities', 'materials'));
    }

    /**
     * Show the form for creating a new facility.
     */
    public function create()
    {
        $materials = Material::all();
        return view('facilities.create', compact('materials'));
    }

    /**
     * Store a newly created facility in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'last_update_date' => 'required|date',
            'street_address' => 'required|string',
            'materials' => 'array|required'
        ]);

        $facility = Facility::create($validated);
        $facility->materials()->sync($request->materials);

        return redirect()->route('facilities.index')->with('success', 'Facility added successfully.');
    }

    /**
     * Display the specified facility.
     */
    public function show(Facility $facility)
    {
        $facility->load('materials');
        return view('facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified facility.
     */
    public function edit(Facility $facility)
    {
        $materials = Material::all();
        $facility->load('materials');
        return view('facilities.edit', compact('facility', 'materials'));
    }

    /**
     * Update the specified facility in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'last_update_date' => 'required|date',
            'street_address' => 'required|string',
            'materials' => 'array|required'
        ]);

        $facility->update($validated);
        $facility->materials()->sync($request->materials);

        return redirect()->route('facilities.index')->with('success', 'Facility updated successfully.');
    }

    /**
     * Remove the specified facility from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('facilities.index')->with('success', 'Facility deleted successfully.');
    }

    /**
     * Export facilities to CSV based on filters/search.
     */
    public function exportCsv(Request $request)
    {
        $fileName = 'facilities.csv';
        $facilities = Facility::with('materials');

        if ($materialId = $request->input('material_id')) {
            $facilities->whereHas('materials', function ($q) use ($materialId) {
                $q->where('materials.id', $materialId);
            });
        }

        $facilities = $facilities->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($facilities) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Business Name', 'Last Updated', 'Address', 'Materials Accepted']);

            foreach ($facilities as $facility) {
                fputcsv($file, [
                    $facility->business_name,
                    $facility->last_update_date,
                    $facility->street_address,
                    $facility->materials->pluck('name')->join(', ')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
