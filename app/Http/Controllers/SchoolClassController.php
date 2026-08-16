<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of master classes.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $classes = SchoolClass::withCount('students')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(15);

        return view('admin.classes.index', compact('classes', 'search'));
    }

    /**
     * Store a newly created master class.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:school_classes,name',
        ], [
            'name.unique' => 'Nama kelas ini sudah ada dalam daftar Master Kelas.',
        ]);

        SchoolClass::create([
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Master Kelas baru berhasil ditambahkan!');
    }

    /**
     * Update the specified master class.
     */
    public function update(Request $request, $id)
    {
        $class = SchoolClass::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:school_classes,name,' . $id,
        ], [
            'name.unique' => 'Nama kelas ini sudah ada dalam daftar Master Kelas.',
        ]);

        $class->update([
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Nama Master Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified master class.
     */
    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);

        if ($class->students()->exists()) {
            return redirect()->route('admin.classes.index')->with('error', 'Master Kelas ini tidak dapat dihapus karena sedang digunakan oleh siswa.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Master Kelas berhasil dihapus!');
    }
}
