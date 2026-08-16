<?php

namespace App\Http\Controllers;

use App\Models\FFQResponse;
use App\Models\KnowledgeResponse;
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

        if (TpbResponse::where('student_id', $student->id)->where('phase', $phase)->exists()) {
            return redirect()->route('survey.index')->with('info', 'Anda sudah mengisi Kuesioner TPB untuk fase ' . $phase . '. Terima kasih!');
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

        if (TpbResponse::where('student_id', $student->id)->where('phase', $phase)->exists()) {
            return redirect()->route('survey.index')->with('info', 'Anda sudah mengisi Kuesioner TPB untuk fase ' . $phase . '.');
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

        return redirect()->route('survey.index')->with('success', 'Kuesioner TPB Fase ' . $phase . ' berhasil dikirim! Anda mendapatkan +20 poin gamifikasi.');
    }

    private function determineCurrentPhase($studentId)
    {
        $t0Complete = FFQResponse::where('student_id', $studentId)->where('phase', 'T0')->exists()
            && TpbResponse::where('student_id', $studentId)->where('phase', 'T0')->exists()
            && KnowledgeResponse::where('student_id', $studentId)->where('phase', 'T0')->exists();

        if (!$t0Complete) {
            return 'T0';
        }

        $t1Complete = FFQResponse::where('student_id', $studentId)->where('phase', 'T1')->exists()
            && TpbResponse::where('student_id', $studentId)->where('phase', 'T1')->exists()
            && KnowledgeResponse::where('student_id', $studentId)->where('phase', 'T1')->exists();

        if (!$t1Complete) {
            return 'T1';
        }

        $t2Complete = FFQResponse::where('student_id', $studentId)->where('phase', 'T2')->exists()
            && TpbResponse::where('student_id', $studentId)->where('phase', 'T2')->exists()
            && KnowledgeResponse::where('student_id', $studentId)->where('phase', 'T2')->exists();

        if (!$t2Complete) {
            return 'T2';
        }

        return 'completed';
    }
}

