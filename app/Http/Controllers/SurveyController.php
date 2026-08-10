<?php

namespace App\Http\Controllers;

use App\Models\FFQResponse;
use App\Models\KnowledgeQuestion;
use App\Models\KnowledgeResponse;
use App\Models\UsabilityResponse;
use App\Models\TpbQuestion;
use App\Models\TpbResponse;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    // List 20 Minuman Standard Baku FFQ & Gram Gula per 100ml
    public static function getFFQBeverageMaster()
    {
        return [
            ['name' => 'Teh manis kemasan', 'sugar_100ml' => 9.8],
            ['name' => 'Teh tarik', 'sugar_100ml' => 11.2],
            ['name' => 'Boba', 'sugar_100ml' => 14.2],
            ['name' => 'Kopi susu', 'sugar_100ml' => 12.4],
            ['name' => 'Cappuccino sachet', 'sugar_100ml' => 10.5],
            ['name' => 'Minuman soda', 'sugar_100ml' => 10.6],
            ['name' => 'Minuman energi', 'sugar_100ml' => 11.3],
            ['name' => 'Susu rasa coklat', 'sugar_100ml' => 9.5],
            ['name' => 'Yogurt manis', 'sugar_100ml' => 11.0],
            ['name' => 'Jus kemasan', 'sugar_100ml' => 10.8],
            ['name' => 'Sirup', 'sugar_100ml' => 15.0],
            ['name' => 'Minuman isotonik', 'sugar_100ml' => 6.4],
            ['name' => 'Thai tea', 'sugar_100ml' => 13.5],
            ['name' => 'Matcha latte', 'sugar_100ml' => 12.0],
            ['name' => 'Milkshake', 'sugar_100ml' => 14.5],
            ['name' => 'Minuman coklat', 'sugar_100ml' => 12.8],
            ['name' => 'Es kopi gula aren', 'sugar_100ml' => 12.4],
            ['name' => 'Minuman jelly', 'sugar_100ml' => 10.0],
            ['name' => 'Bubble drink', 'sugar_100ml' => 13.8],
            ['name' => 'Minuman kemasan lainnya', 'sugar_100ml' => 10.0],
        ];
    }

    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.profile.setup');
        }

        $phase = $this->determineCurrentPhase($student->id);

        $ffqDone = FFQResponse::where('student_id', $student->id)->where('phase', $phase)->exists();
        $tpbDone = TpbResponse::where('student_id', $student->id)->where('phase', $phase)->exists();
        $knowledgeDone = KnowledgeResponse::where('student_id', $student->id)->where('phase', $phase)->exists();
        $usabilityDone = UsabilityResponse::where('student_id', $student->id)->exists();

        return view('survey.index', compact('student', 'phase', 'ffqDone', 'tpbDone', 'knowledgeDone', 'usabilityDone'));
    }

    // --- 1. FFQ SURVEI (7 HARI) ---
    public function ffqForm()
    {
        $student = Auth::user()->student;
        $phase = $this->determineCurrentPhase($student->id);

        if (FFQResponse::where('student_id', $student->id)->where('phase', $phase)->exists()) {
            return redirect()->route('survey.index')->with('info', 'Anda sudah mengisi FFQ untuk fase ' . $phase);
        }

        $beverages = self::getFFQBeverageMaster();

        return view('survey.ffq', compact('beverages', 'phase'));
    }

    public function ffqStore(Request $request)
    {
        $student = Auth::user()->student;
        $phase = $this->determineCurrentPhase($student->id);

        $beverages = self::getFFQBeverageMaster();

        $rules = [];
        foreach ($beverages as $idx => $b) {
            $rules["freq.{$idx}"] = 'required|in:0,1,2,3,4';
            $rules["portion.{$idx}"] = 'required|in:250,350,450';
        }

        $validated = $request->validate($rules);

        $totalDailySugar = 0;
        $itemsData = [];

        // Map faktor frekuensi harian (0 = 0, 1-2x/mgg = 1.5/7, 3-4x/mgg = 3.5/7, 5-6x/mgg = 5.5/7, Setiap hari = 1)
        $freqFactors = [
            0 => 0,
            1 => 1.5 / 7,
            2 => 3.5 / 7,
            3 => 5.5 / 7,
            4 => 1.0,
        ];

        foreach ($beverages as $idx => $b) {
            $freqCode = (int) $validated['freq'][$idx];
            $portionMl = (int) $validated['portion'][$idx];
            $factor = $freqFactors[$freqCode];

            // Gram gula per konsumsi = portionMl * (sugar_100ml / 100)
            $gramsPerServing = $portionMl * ($b['sugar_100ml'] / 100);
            $dailySugarFromThisItem = $gramsPerServing * $factor;

            $totalDailySugar += $dailySugarFromThisItem;

            $itemsData[] = [
                'name' => $b['name'],
                'sugar_100ml' => $b['sugar_100ml'],
                'freq_code' => $freqCode,
                'portion_ml' => $portionMl,
                'daily_sugar_grams' => round($dailySugarFromThisItem, 2),
            ];
        }

        $totalDailySugar = round($totalDailySugar, 2);

        $category = 'Baik';
        if ($totalDailySugar > 50) {
            $category = 'Tinggi';
        } elseif ($totalDailySugar >= 25) {
            $category = 'Sedang';
        }

        FFQResponse::create([
            'student_id' => $student->id,
            'phase' => $phase,
            'items_data' => $itemsData,
            'total_daily_sugar_grams' => $totalDailySugar,
            'category' => $category,
            'answered_at' => now(),
        ]);

        PointHistory::create([
            'user_id' => Auth::id(),
            'points_earned' => 20,
            'description' => 'Mengisi FFQ 7 Hari Fase ' . $phase,
        ]);

        return redirect()->route('survey.index')->with('success', "FFQ Fase {$phase} berhasil disimpan! Rata-rata asupan gula FFQ Anda: {$totalDailySugar} g/hari ({$category}). +20 Poin!");
    }

    // --- 2. PENGETAHUAN GULA (10 SOAL PG) ---
    public function knowledgeForm()
    {
        $student = Auth::user()->student;
        $phase = $this->determineCurrentPhase($student->id);

        if (KnowledgeResponse::where('student_id', $student->id)->where('phase', $phase)->exists()) {
            return redirect()->route('survey.index')->with('info', 'Anda sudah mengisi kuesioner pengetahuan untuk fase ' . $phase);
        }

        $questions = KnowledgeQuestion::where('is_active', true)->get();

        return view('survey.knowledge', compact('questions', 'phase'));
    }

    public function knowledgeStore(Request $request)
    {
        $student = Auth::user()->student;
        $phase = $this->determineCurrentPhase($student->id);

        $questions = KnowledgeQuestion::where('is_active', true)->get();

        $rules = [];
        foreach ($questions as $q) {
            $rules["answers.{$q->id}"] = 'required|in:A,B,C,D';
        }

        $validated = $request->validate($rules, [
            'answers.*.required' => 'Setiap pertanyaan wajib dijawab.',
        ]);

        $score = 0;
        $userAnswers = [];

        foreach ($questions as $q) {
            $ans = $validated['answers'][$q->id];
            $userAnswers[$q->id] = $ans;
            if ($ans === $q->correct_option) {
                $score++;
            }
        }

        $category = 'Kurang';
        if ($score >= 8) {
            $category = 'Baik';
        } elseif ($score >= 6) {
            $category = 'Cukup';
        }

        KnowledgeResponse::create([
            'student_id' => $student->id,
            'phase' => $phase,
            'score' => $score,
            'category' => $category,
            'answers' => $userAnswers,
            'answered_at' => now(),
        ]);

        PointHistory::create([
            'user_id' => Auth::id(),
            'points_earned' => 20,
            'description' => 'Mengisi Kuesioner Pengetahuan Gula Fase ' . $phase,
        ]);

        return redirect()->route('survey.index')->with('success', "Kuesioner Pengetahuan Fase {$phase} berhasil dikirim! Skor Anda: {$score}/10 ({$category}). +20 Poin!");
    }

    // --- 3. EVALUASI USABILITY APLIKASI (SUS 10 ITEM) ---
    public function usabilityForm()
    {
        $student = Auth::user()->student;

        if (UsabilityResponse::where('student_id', $student->id)->exists()) {
            return redirect()->route('survey.index')->with('info', 'Anda sudah mengisi Evaluasi Usability Aplikasi.');
        }

        $items = [
            1 => 'SmartSip Web mudah dipelajari.',
            2 => 'Menu mudah dipahami.',
            3 => 'Tampilan menarik.',
            4 => 'Informasi mudah dimengerti.',
            5 => 'Saya dapat menggunakan aplikasi tanpa bantuan orang lain.',
            6 => 'Fitur berjalan dengan baik.',
            7 => 'Saya merasa nyaman menggunakan aplikasi.',
            8 => 'Saya ingin terus menggunakan aplikasi ini.',
            9 => 'Saya akan merekomendasikan aplikasi ini kepada teman.',
            10 => 'Secara keseluruhan saya puas menggunakan SmartSip Web.',
        ];

        return view('survey.usability', compact('items'));
    }

    public function usabilityStore(Request $request)
    {
        $student = Auth::user()->student;

        $rules = [];
        for ($i = 1; $i <= 10; $i++) {
            $rules["scores.{$i}"] = 'required|integer|min:1|max:5';
        }

        $validated = $request->validate($rules);

        $totalScore = array_sum($validated['scores']);

        $category = 'Kurang';
        if ($totalScore >= 41) {
            $category = 'Sangat Baik';
        } elseif ($totalScore >= 31) {
            $category = 'Baik';
        } elseif ($totalScore >= 21) {
            $category = 'Cukup';
        }

        UsabilityResponse::create([
            'student_id' => $student->id,
            'scores' => $validated['scores'],
            'total_score' => $totalScore,
            'category' => $category,
            'answered_at' => now(),
        ]);

        PointHistory::create([
            'user_id' => Auth::id(),
            'points_earned' => 30,
            'description' => 'Mengisi Evaluasi Usability Aplikasi (SUS)',
        ]);

        return redirect()->route('survey.index')->with('success', "Terima kasih! Evaluasi Usability berhasil dikirim. Skor Usability: {$totalScore}/50 ({$category}). +30 Poin!");
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
