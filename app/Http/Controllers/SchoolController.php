<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $schools = School::with('schoolClasses')
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

        return redirect()->route('schools.index')->with('success', 'Sekolah baru berhasil ditambahkan!');
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

        if ($school->schoolClasses()->exists()) {
            return redirect()->route('schools.index')->with('error', 'Sekolah ini memiliki kelas belajar. Silakan hapus kelas-kelas di dalamnya terlebih dahulu.');
        }

        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Sekolah berhasil dihapus!');
    }

    /**
     * Add a class to a school.
     */
    public function storeClass(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        // Pastikan nama kelas unik di sekolah yang sama
        $exists = SchoolClass::where('school_id', $school->id)
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return redirect()->route('schools.index')->with('error', 'Kelas dengan nama tersebut sudah ada di sekolah ini.');
        }

        SchoolClass::create([
            'school_id' => $school->id,
            'name' => $validated['name'],
        ]);

        return redirect()->route('schools.index')->with('success', 'Kelas baru berhasil ditambahkan ke ' . $school->name . '!');
    }

    /**
     * Remove a class.
     */
    public function destroyClass($id)
    {
        $class = SchoolClass::findOrFail($id);

        if ($class->students()->exists()) {
            return redirect()->route('schools.index')->with('error', 'Kelas ini tidak dapat dihapus karena masih berisi siswa.');
        }

        $class->delete();

        return redirect()->route('schools.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
