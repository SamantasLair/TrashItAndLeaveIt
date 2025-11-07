<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $labs = Lab::all();
        return view('bansus.labs.index', compact('labs'));
    }

    public function create()
    {
        return view('bansus.labs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        Lab::create($request->all());

        return redirect()->route('admin.labs.index')->with('success', 'Lab berhasil ditambahkan.');
    }

    public function show(Lab $lab)
    {
        return view('bansus.labs.show', compact('lab'));
    }

    public function edit(Lab $lab)
    {
        return view('bansus.labs.edit', compact('lab'));
    }

    public function update(Request $request, Lab $lab)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        $lab->update($request->all());

        return redirect()->route('admin.labs.index')->with('success', 'Lab berhasil diperbarui.');
    }

    public function destroy(Lab $lab)
    {
        $lab->delete();
        return redirect()->route('admin.labs.index')->with('success', 'Lab berhasil dihapus.');
    }
}