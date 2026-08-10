<?php

namespace App\Http\Controllers;

use App\Models\TpbQuestion;
use App\Models\TpbResponse;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TpbResponseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile.setup');
        }

        // Tentukan fase saat ini
        $phase = $this->determineCurrentPhase($student->id);

        if ($phase === 'completed') {
            return view('questionnaire.completed');
        }

        $questions = TpbQuestion::where('is_active', true)->get();

        return view('questionnaire.index', compact('questions', 'phase'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile.setup');
        }

        $phase = $this->determineCurrentPhase($student->id);
        if ($phase === 'completed') {
            return redirect()->route('dashboard')->with('error', 'Kuesioner Anda untuk semua fase sudah diisi!');
        }

        $questions = TpbQuestion::where('is_active', true)->get();

        $rules = [];
        foreach ($questions as $q) {
            $rules['answers.' . $q->id] = 'required|integer|min:1|max:5';
        }

        $validated = $request->validate($rules, [
            'answers.*.required' => 'Setiap pertanyaan kuesioner wajib dijawab.',
        ]);

        // Simpan jawaban kuesioner
        foreach ($validated['answers'] as $questionId => $score) {
            TpbResponse::create([
                'student_id' => $student->id,
                'question_id' => $questionId,
                'phase' => $phase,
                'score' => $score,
                'answered_at' => now(),
            ]);
        }

        // Hadiah poin gamifikasi
        PointHistory::create([
            'user_id' => $user->id,
            'points_earned' => 20,
            'description' => 'Mengisi Kuesioner TPB Fase ' . $phase,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kuesioner TPB Fase ' . $phase . ' berhasil dikirim! Anda mendapatkan +20 poin gamifikasi.');
    }

    private function determineCurrentPhase($studentId)
    {
        $hasT0 = TpbResponse::where('student_id', $studentId)->where('phase', 'T0')->exists();
        if (!$hasT0) {
            return 'T0';
        }

        $hasT1 = TpbResponse::where('student_id', $studentId)->where('phase', 'T1')->exists();
        if (!$hasT1) {
            return 'T1';
        }

        $hasT2 = TpbResponse::where('student_id', $studentId)->where('phase', 'T2')->exists();
        if (!$hasT2) {
            return 'T2';
        }

        return 'completed';
    }
}
