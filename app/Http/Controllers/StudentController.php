<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of all student profiles (Antropometri & Demografi).
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $schoolFilter = $request->get('school_id');
        $classFilter = $request->get('class_id');
        $genderFilter = $request->get('gender');

        $students = Student::with(['user', 'school', 'schoolClass'])
            ->when($search, function ($q) use ($search) {
                $q->where('nickname', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            })
            ->when($schoolFilter, function ($q) use ($schoolFilter) {
                $q->where('school_id', $schoolFilter);
            })
            ->when($classFilter, function ($q) use ($classFilter) {
                $q->where('class_id', $classFilter);
            })
            ->when($genderFilter, function ($q) use ($genderFilter) {
                $q->where('gender', $genderFilter);
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $schools = School::all();
        $classes = SchoolClass::all();

        return view('admin.students.index', compact('students', 'schools', 'classes', 'search', 'schoolFilter', 'classFilter', 'genderFilter'));
    }

    /**
     * Update specified student anthropometry data.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'nickname' => 'required|string|max:100',
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:school_classes,id',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date',
            'height_cm' => 'required|numeric|min:50|max:250',
            'weight_kg' => 'required|numeric|min:20|max:300',
            'body_fat_percentage' => 'nullable|numeric|min:0|max:100',
            'pocket_money' => 'nullable|numeric|min:0',
            'father_education' => 'nullable|string|max:100',
            'mother_education' => 'nullable|string|max:100',
        ]);

        // Hitung ulang IMT (BMI) otomatis
        $heightM = $validated['height_cm'] / 100;
        $validated['bmi_score'] = round($validated['weight_kg'] / ($heightM * $heightM), 1);

        $student->update($validated);

        return redirect()->route('admin.students.index')->with('success', 'Data Profil & Antropometri Siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified student profile.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // Hapus profil siswa
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Data Profil Siswa berhasil dihapus!');
    }
}
