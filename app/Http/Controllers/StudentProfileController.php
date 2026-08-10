<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function create()
    {
        if (Auth::user()->student) {
            return redirect()->route('dashboard');
        }

        $schools = School::all();
        $classes = SchoolClass::all();

        return view('students.setup', compact('schools', 'classes'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->student) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'class_id' => 'required|exists:school_classes,id',
            'nickname' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'required|date|before:today',
            'height_cm' => 'required|numeric|min:50|max:250',
            'weight_kg' => 'required|numeric|min:10|max:200',
            'body_fat_percentage' => 'nullable|numeric|min:1|max:80',
            'pocket_money' => 'required|string',
            'father_education' => 'required|string',
            'mother_education' => 'required|string',
            'informed_consent' => 'required|accepted',
        ], [
            'informed_consent.accepted' => 'Anda wajib menyetujui lembar persetujuan (informed consent) untuk berpartisipasi dalam riset ini.',
        ]);

        $heightM = $validated['height_cm'] / 100;
        $bmiScore = $validated['weight_kg'] / ($heightM * $heightM);

        Student::create([
            'user_id' => Auth::id(),
            'school_id' => $validated['school_id'],
            'class_id' => $validated['class_id'],
            'nickname' => $validated['nickname'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'height_cm' => $validated['height_cm'],
            'weight_kg' => $validated['weight_kg'],
            'bmi_score' => round($bmiScore, 2),
            'body_fat_percentage' => $validated['body_fat_percentage'] ?? null,
            'pocket_money' => $validated['pocket_money'],
            'father_education' => $validated['father_education'],
            'mother_education' => $validated['mother_education'],
            'informed_consent' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil Anda berhasil dilengkapi! Selamat memantau asupan gula harian.');
    }
}
