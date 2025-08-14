<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials.
     */
    public function index()
    {
        $materials = Material::all();
        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Material::create($request->only('name'));

        return redirect()->route('materials.index')->with('success', 'Material added successfully.');
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $material->update($request->only('name'));

        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
