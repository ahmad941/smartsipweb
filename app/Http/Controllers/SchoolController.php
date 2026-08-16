<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $schools = School::withCount('students')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('group_type', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.schools.index', compact('schools', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:schools,name',
            'group_type' => 'required|in:intervensi,kontrol',
        ]);

        School::create($validated);

        return redirect()->route('schools.index')->with('success', 'Sekolah Mitra baru berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:schools,name,' . $school->id,
            'group_type' => 'required|in:intervensi,kontrol',
        ]);

        $school->update($validated);

        return redirect()->route('schools.index')->with('success', 'Data sekolah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        if ($school->students()->exists()) {
            return redirect()->route('schools.index')->with('error', 'Sekolah ini tidak dapat dihapus karena sudah memiliki siswa terdaftar.');
        }

        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil dihapus!');
    }
}
